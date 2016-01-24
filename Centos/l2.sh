#!/bin/bash
function installVPN(){
if [ $(id -u) != "0" ]; then
    printf "Error: You must be root to run this tool!\n"
    exit 1
fi
clear
echo -e "\033[7m"
printf "
####################################################
#                                                  #
# This is a Shell-Based tool of l2tp installation  #
# Version: 1.0                                     #
# Author: Myrte                                    #
# Website: http://WWW.VpsYou.com                   #
# Platform: CentOS 6.x x86/x86_64                  #
####################################################
"
echo -e "\033[0m"

vpsip=`ifconfig  | grep 'inet addr:'| grep -v '127.0.0.1' | cut -d: -f2 | awk 'NR==1 { print $1}'`

iprange="10.0.99"
echo "Please input IP-Range:"
read -p "(Default Range: 10.0.99):" iprange
if [ "$iprange" = "" ]; then
	iprange="10.0.99"
fi

mypsk="vpsyou.com"
echo "Please input PSK:"
read -p "(Default PSK: vpsyou.com):" mypsk
if [ "$mypsk" = "" ]; then
	mypsk="vpsyou.com"
fi

#gateway="192.168.0.1"
#echo "Please input Gateway of your Server:"
#read -p "(For example: 192.168.0.1):" gateway
#if [ "$gateway" = "" ]; then
#	gateway="192.168.0.1"
#fi

firstuser="myrte"
echo "Please input The First Vpn User Name:"
read -p "(For example: myrte):" firstuser
if [ "$firstuser" = "" ]; then
	firstuser="myrte"
fi

firstpwd="12345678"
echo "Please input The First User Password:"
read -p "(For example: 12345678):" firstpwd
if [ "$firstpwd" = "" ]; then
	firstpwd="12345678"
fi

clear
get_char()
{
SAVEDSTTY=`stty -g`
stty -echo
stty cbreak
dd if=/dev/tty bs=1 count=1 2> /dev/null
stty -raw
stty echo
stty $SAVEDSTTY
}
echo ""
echo "ServerIP:"
echo "$vpsip"
echo ""
echo "Server Local IP:"
echo "$iprange.1"
echo ""
echo "Client Remote IP Range:"
echo "$iprange.2-$iprange.254"
echo ""
echo "PSK:"
echo "$mypsk"
echo ""
#echo "Gateway:"
#echo "$gateway"
#echo ""
echo "First user:"
echo "$firstuser"
echo ""
echo "First Password:"
echo "$firstpwd"
echo ""
echo "Press any key to start..."
char=`get_char`
clear
mknod /dev/random c 1 9
yum -y update
yum install -y ppp iptables make zip unzip gcc gmp-devel xmlto bison flex xmlto libpcap-devel lsof vim-enhanced
wd=`pwd`
wd_work=`pwd`/work
mkdir -p $wd_work
cd $wd_work
tar zxvf openswan-2.6.36.tar.gz
cd openswan-2.6.36
make programs install
rm -rf /etc/ipsec.conf
touch /etc/ipsec.conf
cat >>/etc/ipsec.conf<<EOF
config setup
    nat_traversal=yes
    virtual_private=%v4:10.0.0.0/8,%v4:192.168.0.0/16,%v4:172.16.0.0/12
    oe=off
    protostack=netkey

conn L2TP-PSK-NAT
    rightsubnet=vhost:%priv
    also=L2TP-PSK-noNAT

conn L2TP-PSK-noNAT
    authby=secret
    pfs=no
    auto=add
    keyingtries=3
    rekey=no
    ikelifetime=8h
    keylife=1h
    type=transport
    left=$vpsip
	leftid=$vpsip
	leftnexthop=$vpsip
    leftprotoport=17/1701
    right=%any
    rightprotoport=17/%any
EOF
cat >>/etc/ipsec.secrets<<EOF
$vpsip %any: PSK "$mypsk"
EOF
sed -i 's/net.ipv4.ip_forward = 0/net.ipv4.ip_forward = 1/g' /etc/sysctl.conf
sysctl -p
iptables --table nat --append POSTROUTING --jump MASQUERADE
iptables -I INPUT -p udp -m multiport --dport 1701,4500,500 -j ACCEPT

for each in /proc/sys/net/ipv4/conf/*
do
echo 0 > $each/accept_redirects
echo 0 > $each/send_redirects
done
/etc/init.d/ipsec restart
ipsec verify

cd $wd_work
tar zxvf rp-l2tp-0.4.tar.gz
cd rp-l2tp-0.4
./configure
make
cp handlers/l2tp-control /usr/local/sbin/
mkdir /var/run/xl2tpd/
ln -s /usr/local/sbin/l2tp-control /var/run/xl2tpd/l2tp-control
cd $wd_work
tar zxvf xl2tpd-1.3.1.tar.gz
cd xl2tpd-1.3.1
make install
mkdir /etc/xl2tpd
rm -rf /etc/xl2tpd/xl2tpd.conf
touch /etc/xl2tpd/xl2tpd.conf
cat >>/etc/xl2tpd/xl2tpd.conf<<EOF
[global]
ipsec saref = yes
[lns default]
ip range = $iprange.2-$iprange.254
local ip = $iprange.1
refuse chap = yes
refuse pap = yes
require authentication = yes
ppp debug = yes
pppoptfile = /etc/ppp/options.xl2tpd
length bit = yes
EOF
rm -rf /etc/ppp/options.xl2tpd
touch /etc/ppp/options.xl2tpd
cat >>/etc/ppp/options.xl2tpd<<EOF
require-mschap-v2
ms-dns 114.114.114.114
ms-dns 8.8.8.8
asyncmap 0
auth
crtscts
lock
hide-password
modem
debug
name l2tpd
proxyarp
lcp-echo-interval 30
lcp-echo-failure 4
EOF

rm -rf /etc/ppp/options
touch /etc/ppp/options
cat >>/etc/ppp/options<<EOF
require-mschap-v2
ms-dns 8.8.8.8
ms-dns 8.8.4.4
asyncmap 0
auth
crtscts
lock
hide-password
modem
debug
name l2tpd
proxyarp
lcp-echo-interval 30
lcp-echo-failure 4
EOF
cat >>/etc/ppp/chap-secrets<<EOF
$firstuser l2tpd $firstpwd *
EOF

cd $wd_work
cp -rp ip-up.local /etc/ppp/
chmod -R 777 /etc/ppp/ip-up.local
touch /usr/bin/zl2tpset
echo "#/bin/bash" >>/usr/bin/zl2tpset
echo "for each in /proc/sys/net/ipv4/conf/*" >>/usr/bin/zl2tpset
echo "do" >>/usr/bin/zl2tpset
echo "echo 0 > \$each/accept_redirects" >>/usr/bin/zl2tpset
echo "echo 0 > \$each/send_redirects" >>/usr/bin/zl2tpset
echo "done" >>/usr/bin/zl2tpset
chmod +x /usr/bin/zl2tpset
iptables --table nat --append POSTROUTING --jump MASQUERADE
iptables -I INPUT -p udp -m multiport --dport 1701,4500,500 -j ACCEPT
zl2tpset
xl2tpd
service iptables save 
service iptables restart
cat >>/etc/rc.local<<EOF
iptables -I INPUT -p udp -m multiport --dport 1701,4500,500 -j ACCEPT
iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
/etc/init.d/ipsec restart
/usr/bin/zl2tpset
/usr/local/sbin/xl2tpd
EOF
clear
ipsec verify
echo -e "\033[7m"
printf "
####################################################
#                                                  #
# This is a Shell-Based tool of l2tp installation  #
# Version: 1.0                                     #
# Author: Myrte                                    #
# Website: http://WWW.VpsYou.com                   #
# Platform: CentOS 6.x x86/x86_64                  #
####################################################
if there are no [FAILED] above, then you can
connect to your L2TP VPN Server with the default
user/pass below:

ServerIP:$vpsip
username:$firstuser
password:$firstpwd
PSK:$mypsk

"
echo -e "\033[0m"
}
function repaireVPN(){
	echo "begin to repaire VPN";
	rm -rf /dev/random
	mknod /dev/random c 1 9
	service iptables restart
	/etc/init.d/ipsec restart
	/usr/bin/killall xl2tpd
	/usr/local/sbin/xl2tpd
}

function addVPNuser(){
	echo "input user name:"
	read username
	echo "input password:"
	read userpassword
	echo "${username} l2tpd ${userpassword} *" >> /etc/ppp/chap-secrets
	service iptables restart
	/etc/init.d/ipsec restart
	/usr/bin/killall xl2tpd
	/usr/local/sbin/xl2tpd
}
echo -e "\033[7m"
printf "
####################################################
#                                                  #
# This is a Shell-Based tool of l2tp installation  #
# Version: 1.0                                     #
# Author: Myrte                                    #
# Website: http://WWW.VpsYou.com                   #
# Platform: CentOS 6.x x86/x86_64                  #
####################################################

which do you want to?input the number:
1. install VPN service
2. repaire VPN service
3. add VPN user
"
echo -e "\033[0m"

read num

case "$num" in
[1] ) (installVPN);;
[2] ) (repaireVPN);;
[3] ) (addVPNuser);;
*) echo "nothing,exit";;
esac
