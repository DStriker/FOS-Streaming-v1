#!/bin/bash
apt-get update
apt-get upgrade 
echo "Done apt-get"
echo "Installing PHP5-CLI CURL"
apt-get -y install php5-cli curl
echo "Done"
cd /tmp
wget https://github.com/DStriker/FOS-Streaming-v2.0-UNOFFICIAL-/raw/master/install.php.1
mv install.php.1 install.php
php install.php
wget https://github.com/DStriker/FOS-Streaming-v2.0-UNOFFICIAL-/raw/master/db_install.sh
chmod 755 db_install.sh
./db_install.sh
