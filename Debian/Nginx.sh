apt-get update
apt-get install -y git gcc g++ make automake libpcre3 libpcre3-dev openssl libssl-dev screen htop
git clone https://github.com/yaoweibin/ngx_http_substitutions_filter_module
wget -c https://nginx.org/download/nginx-1.11.7.tar.gz
tar zxvf nginx-*.tar.gz
cd nginx-*
./configure --prefix=/usr/local/nginx --with-http_stub_status_module --with-http_v2_module --with-http_ssl_module --with-http_gzip_static_module --with-ipv6 --with-http_sub_module --add-module=/root/ngx_http_substitutions_filter_module
make
make install
find / -name nginx
/usr/local/nginx/sbin/nginx -V

