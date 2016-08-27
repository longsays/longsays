apt-get -y install wget screen unzip
screen -S longsays
wget --no-check-certificate https://raw.githubusercontent.com/teddysun/across/master/l2tp.sh
chmod +x l2tp.sh
time ./l2tp.sh
wget --no-check-certificate https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocksR.sh
chmod +x shadowsocksR.sh
time ./shadowsocksR.sh

