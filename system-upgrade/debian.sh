#!/bin/bash

# =================================================================
# Debian 10/11/12 -> 13 自动化逐级升级脚本
# =================================================================

# 1. 基础环境检查
if [[ $EUID -ne 0 ]]; then
   echo -e "\033[31m[ERROR] 请使用 root 权限运行此脚本\033[0m"
   exit 1
fi

# 2. 核心安全性检查：dpkg 状态审计
echo "[INFO] 正在执行系统软件包状态审计 (dpkg audit)..."
# 先尝试修复可能存在的微小配置问题
dpkg --configure -a 2>/dev/null
AUDIT_OUTPUT=$(dpkg --audit 2>&1)
if [ -n "$AUDIT_OUTPUT" ]; then
    echo -e "\033[31m[ERROR] 检测到系统存在损坏或未完成安装的软件包！\033[0m"
    echo -e "详细错误信息如下：\n$AUDIT_OUTPUT"
    echo -e "\033[33m建议处理：请手动运行 'apt --fix-broken install' 修复后再运行本脚本。\033[0m"
    exit 1
fi
echo -e "\033[32m[OK] 系统软件包状态良好，可以继续。\033[0m"

# 3. 检查是否在 screen 或 tmux 中运行
if [[ -z "$STY" && -z "$TMUX" ]]; then
    echo -e "\033[33m[WARN] 建议在 screen 或 tmux 会话中运行，以防网络中断导致升级失败。\033[0m"
    read -p "确定要继续直接运行吗? (y/n): " confirm
    [[ "$confirm" != "y" ]] && exit 1
fi

# 获取当前系统主版本号
if [ -f /etc/os-release ]; then
    . /etc/os-release
    VERSION=${VERSION_ID%%.*}
else
    echo -e "\033[31m[ERROR] 无法确定系统版本\033[0m"
    exit 1
fi

# 备份函数
__backup_sources(){
    local TIMESTAMP=$(date +%Y%m%d%H%M%S)
    echo "[INFO] 正在备份源文件至 /etc/apt/..."
    cp /etc/apt/sources.list "/etc/apt/sources.list.bak_$TIMESTAMP" 2>/dev/null
    if [ -d /etc/apt/sources.list.d ]; then
        tar -czf "/etc/apt/sources.list.d.bak_$TIMESTAMP.tar.gz" -P /etc/apt/sources.list.d 2>/dev/null
    fi
}

# 核心升级指令
__do_apt_upgrade(){
    echo "[INFO] 正在同步软件包索引并执行升级..."
    apt-get update
    if [ $? -ne 0 ]; then
        echo -e "\033[31m[ERROR] apt update 失败。请检查网络或第三方源配置。\033[0m"
        exit 1
    fi

    export DEBIAN_FRONTEND=noninteractive
    
    local OPTS=(
        -y 
        -o Dpkg::Options::="--force-confdef" 
        -o Dpkg::Options::="--force-confold"
    )

    echo "[INFO] 第一阶段：最小化升级 (Safe Upgrade)..."
    apt-get upgrade "${OPTS[@]}"
    
    echo "[INFO] 第二阶段：全量升级 (Full Upgrade)..."
    apt-get dist-upgrade "${OPTS[@]}"
    
    echo "[INFO] 第三阶段：清理过时包..."
    apt-get autoremove -y
    apt-get autoclean
}

# 固件仓库处理
__fix_firmware_repo(){
    if grep -q "non-free" /etc/apt/sources.list && ! grep -q "non-free-firmware" /etc/apt/sources.list; then
        echo "[INFO] 正在处理 non-free-firmware 仓库配置 (Debian 12+ 必需)..."
        sed -i 's/\bnon-free\b/non-free non-free-firmware/g' /etc/apt/sources.list
        # 清理可能产生的重复
        sed -i 's/non-free-firmware non-free-firmware/non-free-firmware/g' /etc/apt/sources.list
    fi
}

# 通用源替换逻辑
__replace_dist_name(){
    local OLD=$1
    local NEW=$2
    echo "[INFO] 将所有软件源从 $OLD 替换为 $NEW ..."
    find /etc/apt/ -type f \( -name "*.list" -o -name "*.sources" \) 2>/dev/null | xargs -r sed -i "s/\b$OLD\b/$NEW/g"
}

__do_debian11_upgrade(){
    echo "[INFO] 准备从 10 升级至 11 (Bullseye)..."
    __do_apt_upgrade 
    __backup_sources
    __replace_dist_name "buster" "bullseye"
    # 修正安全源路径
    sed -i 's/bullseye\/updates/bullseye-security/g' /etc/apt/sources.list
    __do_apt_upgrade
}

__do_debian12_upgrade(){
    echo "[INFO] 准备从 11 升级至 12 (Bookworm)..."
    __do_apt_upgrade
    __backup_sources
    __replace_dist_name "bullseye" "bookworm"
    # 修正安全源路径
    sed -i 's/bullseye-security/bookworm-security/g' /etc/apt/sources.list 2>/dev/null
    sed -i 's/bookworm\/updates/bookworm-security/g' /etc/apt/sources.list 2>/dev/null
    __fix_firmware_repo
    __do_apt_upgrade
}

__do_debian13_upgrade(){
    echo "[INFO] 准备从 12 升级至 13 (Trixie)..."
    __do_apt_upgrade
    __backup_sources
    __replace_dist_name "bookworm" "trixie"
    sed -i 's/bookworm-security/trixie-security/g' /etc/apt/sources.list 2>/dev/null
    __fix_firmware_repo
    __do_apt_upgrade
}

# 逻辑分发
case "$VERSION" in
    10)
        __do_debian11_upgrade
        echo -e "\n\033[32m[SUCCESS] 10 -> 11 完成。请重启 (reboot) 后再次运行本脚本。\033[0m"
        ;;
    11)
        __do_debian12_upgrade
        echo -e "\n\033[32m[SUCCESS] 11 -> 12 完成。请重启 (reboot) 后再次运行本脚本。\033[0m"
        ;;
    12)
        __do_debian13_upgrade
        echo -e "\n\033[32m[SUCCESS] 12 -> 13 升级完成！\033[0m"
        ;;
    13)
        echo "[INFO] 当前已是 Debian 13 (Trixie)。正在检查更新..."
        __do_apt_upgrade
        echo -e "\n\033[32m[INFO] 系统已是最新状态。\033[0m"
        ;;
    *)
        echo -e "\033[33m[WARN] 脚本不支持当前版本 ID: $VERSION_ID。\033[0m"
        ;;
esac

# 检查重启标识
if [ -f /var/run/reboot-required ]; then
    echo "----------------------------------------------------"
    echo -e "\033[35m>>> 检测到内核或核心库更新，请立即执行: reboot\033[0m"
    echo "----------------------------------------------------"
fi
