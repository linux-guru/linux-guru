#!/bin/sh


#############################################################################################################################
##															   														       ##
##   ####### ######  ######  ######   ####### ##   ##  ######  ##   ##  ######   ##   ##     ###     ######   ##     ##	   ##
##     ##    #	     #	       ##     ##      ##   ##  #    #  ##   ##  ##    ## ##   ##    ## ##    ##    #   ##    ##	   ##
##  #  ##    ######  #####     ##     ##      #######  #    #  ##   ##  ##    ## #######   ##   ##   ######      ####	   ##
##  #  ##    #	     #	       ##     ##      ##   ##  #    #  ##   ##  ##    ## ##   ##  #########  ##   ##      ##	   ##
##  #####    ######  ######    ##     ####### ##   ##  ######   #####   ######   ##   ## ##       ## ##    ##     ##	   ##
##															  															   ##
##										Create laarvel server script 										   			   ##
##										 Written By: Jeet Choudhary  						   							   ##
##					 						Last Update: -Jul-2021								       					   ##
##															 															   ##
#############################################################################################################################

##  Website :- www.linuxguru.co.in
##  Email :- suupport@linuxguru.co.in
## 	Contact :- https://linuxguru.co.in/contact/

################################ <<<<===========>>>> Server Scrip Software  <<<<===========>>>> ################################

## Software  List
## Ubuntu 20.04.2
## Upwork
## Chrome
## Sublime
## Tmetric
## Skype
## filezilla
## yakyak
## SSH
## GIT
## Slack
## Hubstuf


################################ <<<<===========>>>> Server Scrip Software <<<===========>>>> ################################

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

rm -rf upwork.deb

sudo apt update

sudo apt install snapd

sudo apt-get install -y ssh

sudo apt-get install -y git

sudo snap install slack --classic

sudo apt-get update

sudo apt-get -y upgrade

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

############################### <<<<===========>>>> permission web folder from user <<<<===========>>>> ################################

exit
