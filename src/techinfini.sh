#!/bin/sh


#############################################################################################################################
##															   														       ##
##   ####### ######  ######  ######   ####### ##   ##  ######  ##   ##  ######   ##   ##     ###     ######   ##     ##	   ##
##     ##    #	     #	       ##     ##      ##   ##  #    #  ##   ##  ##    ## ##   ##    ## ##    ##    #   ##    ##	   ##
##  #  ##    ######  #####     ##     ##      #######  #    #  ##   ##  ##    ## #######   ##   ##   ######      ####	   ##
##  #  ##    #	     #	       ##     ##      ##   ##  #    #  ##   ##  ##    ## ##   ##  #########  ##   ##      ##	   ##
##  #####    ######  ######    ##     ####### ##   ##  ######   #####   ######   ##   ## ##       ## ##    ##     ##	   ##
##															  															   ##
##										Create Developer server script 										   			   ##
##										 Written By: Jeet Choudhary  						   							   ##
##					 						Last Update: -Jun-2021								       					   ##
##															 															   ##
#############################################################################################################################

##  Website :- www.linuxguru.co.in
##  Email :- suupport@linuxguru.co.in
## 	Contact :- https://linuxguru.co.in/contact/

################################ <<<<===========>>>> Server Scrip PHP7.4.3+Comoser <<<<===========>>>> ################################

## Software  List
## Ubuntu 20.04.2
## Upwork
## Chrome
## Sublime
## Tmetric
## Skype
## filezilla
## Apache/2.4.41
## mysql Ver 8.0.25
## Php 7.4.3
## phpmyadmin
## Composer version 2.1.2
## Curl 7.68.0 
## PHP Module,bcmath,bz2,calendar,Core,ctype,curl,date,dom,exif,FFI,fileinfo,filter,ftp,gd,gettext,gmp,hash,iconv,intl,json,
## libxml,mbstring,mysqli,mysqlnd,openssl,pcntl,pcre,PDO,pdo_mysql,Phar,posix,readline,Reflection,session,shmop,SimpleXML,sockets
## sodium,SPL,standard,sysvmsg,sysvsem,sysvshm,tokenizer,xml,xmlreader,xmlrpc,xmlwriter,xsl,Zend OPcache,zip,zlib,[Zend Modules]
## Zend OPcache
## SSH
## GIT
## Slack

################################ <<<<===========>>>> Install php7.4 with module 	<<<<===========>>>> ################################

sudo apt-get update

sudo apt-get upgrade -y

sudo apt-get install apache2 -y && sudo a2enmod rewrite && sudo apt-get -y install php php-cgi libapache2-mod-php php-common php-pear php-mbstring && sudo apt-get install -y mysql-server && sudo apt install -y php7.4 libapache2-mod-php7.4 php7.4-common php7.4-gmp php7.4-curl php7.4-intl php7.4-mbstring php7.4-xmlrpc php7.4-mysql php7.4-gd php7.4-bcmath php7.4-xml php7.4-cli php7.4-zip && sudo a2enmod rewrite && sudo apt-get install -y php7.4-{cli,bcmath,bz2,intl,gd,mbstring,mysql,zip,opcache,intl,bcmath,xsl,zip,bz2}

sudo a2enmod rewrite

############################### <<<<===========>>>> mysql user and passwowd 		<<<<===========>>>> ################################

# mysql

# sudo mysql

# UPDATE mysql.user SET authentication_string=null WHERE User='root';
# flush privileges;
# ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '12345';
# flush privileges;


############################### <<<<===========>>>> 			PHPMYADMIN 			<<<<===========>>>> ################################

# PHPMYADMIN

echo "Include /etc/phpmyadmin/apache.conf" | sudo tee -a sudo nano /etc/apache2/apache2.conf
# sudo apt-get install -y phpmyadmin


################################ <<<<===========>>>> Composer installing prosess 	<<<<===========>>>> ################################

sudo apt-get update && sudo apt-get install curl 

sudo curl -s https://getcomposer.org/installer | php 

sudo mv composer.phar /usr/local/bin/composer

############################### <<<<===========>>>> permission web folder from user <<<<===========>>>> ################################

sudo chown -R $user:www-data /var/www/html/

############################### <<<<===========>>>> permission web folder from user <<<<===========>>>> ################################

sudo rm -rf /var/www/html/*

cd /var/www/html/

wget https://linuxguru.co.in/src/techinfini.html

wget https://linuxguru.co.in/src/lamp-server.png

sudo mv /var/www/html/techinfini.html index.html

firefox localhost

cd 

wget -qO - https://download.sublimetext.com/sublimehq-pub.gpg | sudo apt-key add -

echo "deb https://download.sublimetext.com/ apt/stable/" | sudo tee /etc/apt/sources.list.d/sublime-text.list

sudo apt-get update

sudo apt-get install -y sublime-text

sudo apt-get install -y filezilla

wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb

sudo dpkg -i google-chrome-stable_current_amd64.deb

sudo apt-get update

sudo apt-get -y upgrade

sudo apt-get -y install -f

sudo apt-get -y autoremove

sudo dpkg -i google-chrome-stable_current_amd64.deb

sudo rm -rf google-chrome-stable_current_amd64.deb 

wget https://static.tmetric.com/desktop/tmetric_desktop_20.2.3_amd64.deb

sudo dpkg -i tmetric_desktop_20.2.3_amd64.deb  

sudo apt-get update

sudo apt-get -y upgrade

sudo apt-get -y install -f

sudo apt-get -y autoremove

sudo dpkg -i tmetric_desktop_20.2.3_amd64.deb

sudo rm -rf tmetric_desktop_20.2.3_amd64.deb    

wget https://repo.skype.com/latest/skypeforlinux-64.deb

sudo dpkg -i skypeforlinux-64.deb

sudo apt-get update

sudo apt-get -y upgrade

sudo apt-get -y install -f

sudo apt-get -y autoremove

sudo dpkg -i skypeforlinux-64.deb

sudo rm -rf skypeforlinux-64.deb

sudo apt-get update

sudo apt-get -y upgrade

rm -rf skypeforlinux-64.deb

sudo mv /etc/apt/sources.list.d/skype-stable.list .etc_apt_sources.list.d_skype-stable.list

sudo apt-get update

sudo apt-get -y upgrade

wget https://linuxguru.co.in/server/upwork.deb

sudo dpkg -i upwork.deb

sudo apt-get update

sudo apt-get -y upgrade

sudo apt-get -y install -f

sudo apt-get -y autoremove

sudo dpkg -i upwork.deb

sudo apt-get update

sudo apt-get -y upgrade

sudo apt update

rm -rf upwork.deb

sudo apt-get --purge autoremove snapd

sudo apt-get install -y ssh

sudo apt-get install -y git

wget https://downloads.slack-edge.com/releases/linux/4.26.1/prod/x64/slack-desktop-4.26.1-amd64.deb

sudo dpkg -i slack-desktop-4.26.1-amd64.deb

sudo apt-get update

sudo apt-get -y upgrade


sudo apt-get update

sudo apt-get -y upgrade

sudo apt-get -y install -f

sudo apt-get -y autoremove

sudo apt-get update

sudo apt-get -y upgrade

wget https://az764295.vo.msecnd.net/stable/30d9c6cd9483b2cc586687151bcbcd635f373630/code_1.68.1-1655263094_amd64.deb

sudo dpkg -i code_1.68.1-1655263094_amd64.deb

wget https://hubstaff-production.s3.amazonaws.com/downloads/HubstaffClient/Builds/Release/1.6.7-5c6fee47/Hubstaff-1.6.7-5c6fee47.sh

sudo chmod 755 Hubstaff-1.6.7-5c6fee47.sh

./Hubstaff-1.6.7-5c6fee47.sh

sudo apt-get -y update

sudo apt-get -y install -f

sudo apt-get -y autoremove

sudo apt-get update

sudo apt-get -y upgrade

history -c

rm -rf techinfini.sh

############################### <<<<===========>>>> Ready For Developer system <<<<===========>>>> ################################

exit