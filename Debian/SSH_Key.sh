mkdir ~/.ssh
chmod 700 ~/.ssh
wget -c http://qiniu.longsays.com/bucket/Debian/.ssh/authorized_keys
mv -f authorized_keys ~/.ssh/
chmod 644 ~/.ssh/authorized_keys
wget -c http://qiniu.longsays.com/bucket/Debian/etc/ssh/sshd_config
mv -f sshd_config* /etc/ssh/sshd_config
service sshd restart
