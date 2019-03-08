#!/bin/bash

sudo apt-get -y --force-yes install vim git-core tig htop ntp unzip curl
sudo localedef ru_RU.UTF-8 -i ru_RU -fUTF-8

sudo /etc/init.d/ntp restart

sudo useradd ctf

# dotdeb
sudo sed -i 1i'deb-src http://packages.dotdeb.org jessie all' /etc/apt/sources.list
sudo sed -i 1i'deb http://packages.dotdeb.org jessie all' /etc/apt/sources.list
sudo sed -i 1i'### Dotdeb ###' /etc/apt/sources.list
wget -q -O- https://www.dotdeb.org/dotdeb.gpg | sudo apt-key add -

#install
cd /tmp
sudo apt-get update
sudo apt-get -y --force-yes install redis-server

sudo debconf-set-selections <<< 'percona-server-server-5.7 percona-server-server-5.7/root-pass password root'
sudo debconf-set-selections <<< 'percona-server-server-5.7 percona-server-server-5.7/re-root-pass password root'

wget https://repo.percona.com/apt/percona-release_0.1-4.$(lsb_release -sc)_all.deb
sudo dpkg -i percona-release_0.1-4.$(lsb_release -sc)_all.deb
sudo apt-get update
sudo apt-get -y --force-yes install percona-server-server-5.7

sudo apt-get -y --force-yes install php7.0-fpm
sudo apt-get -y --force-yes install nginx-full

sudo apt-get -y --force-yes install php7.0-mbstring php7.0-gd php7.0-mysql php7.0-intl php7.0-bcmath php7.0-xml php7.0-curl

# *** Mysql timezone ***
#
# old - mysql_tzinfo_to_sql /usr/share/zoneinfo | mysql -uroot -proot mysql
#
# https://dev.mysql.com/downloads/timezones.html
# sudo apt-get install mysql-server
wget https://downloads.mysql.com/general/timezone_2017b_posix_sql.zip
unzip timezone_2017b_posix_sql.zip
mysql -uroot -proot mysql < timezone_2017b_posix_sql/timezone_posix.sql
sudo /etc/init.d/mysql restart
rm -r timezone_2017b_posix_sql

#rabbitmq
echo 'deb http://www.rabbitmq.com/debian/ testing main' | sudo tee /etc/apt/sources.list.d/rabbitmq.list
wget -O- https://www.rabbitmq.com/rabbitmq-release-signing-key.asc | sudo apt-key add -
sudo apt-get update
sudo apt-get -y --force-yes install rabbitmq-server
sudo cp /var/www/ctf/data/etc/rabbitmq/rabbitmq.config /etc/rabbitmq/rabbitmq.config
sudo rabbitmq-plugins enable rabbitmq_management

sudo rabbitmqctl add_user admin admin040784
sudo rabbitmqctl set_user_tags admin administrator
sudo rabbitmqctl set_permissions -p / admin ".*" ".*" ".*"

sudo rabbitmqctl delete_user guest

sudo rabbitmqctl add_user ctf ctf48845756
sudo rabbitmqctl set_permissions -p / ctf ".*" ".*" ".*"

sudo /etc/init.d/rabbitmq-server restart

# nginx
sudo rm /etc/nginx/sites-enabled/default
sudo cp /var/www/ctf/data/etc/nginx/sites-available/ctf.conf /etc/nginx/sites-available/ctf.conf
sudo ln -s /etc/nginx/sites-available/ctf.conf /etc/nginx/sites-enabled/ctf.conf
sudo cp /var/www/ctf/data/etc/nginx/sites-available/ctf.app.conf /etc/nginx/sites-available/ctf.app.conf
sudo ln -s /etc/nginx/sites-available/ctf.app.conf /etc/nginx/sites-enabled/ctf.app.conf
sudo /etc/init.d/nginx restart

#application
cd /var/www/ctf
chmod -R 0777 runtime
chmod -R 0777 web/assets

# database
cd /var/www/ctf
mysql -uroot -proot < data/dump.sql
./yii migrate up --interactive=0



# install vue (frontends)
#curl -sL https://deb.nodesource.com/setup_8.x -o nodesource_setup.sh
#sudo bash nodesource_setup.sh
#sudo apt-get install nodejs
#cd /var/www/ctf/frontend
#npm install
#cd /var/www/ctf/frontend_app
#npm install

#sudo npm install -g yarn

### sudo apt-get install runit
### sudo cp -R /var/www/ctf/data/etc/sv/* /etc/sv
### sudo ln -s /etc/sv/comet /etc/service/
### sudo ln -s /etc/sv/command_send /etc/service/
### sudo ln -s /etc/sv/command_status /etc/service/
### sudo ln -s /etc/sv/pull_device /etc/service/
### sudo ln -s /etc/sv/pull_device_queue /etc/service/
### sudo ln -s /etc/sv/pull_sensor_trigger /etc/service/
