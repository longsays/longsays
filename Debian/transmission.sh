sudo su
cd
apt-get update
apt-get install transmission-daemon -y
/etc/init.d/transmission-daemon stop
wget https://qiniu.longsays.com/bucket/transmission/settings.json
mv -f settings.json /var/lib/transmission-daemon/info/
mkdir -p /home/transmission/Downloads/
chmod -R 777 /home/transmission/Downloads/
/etc/init.d/transmission-daemon start