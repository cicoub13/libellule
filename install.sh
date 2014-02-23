#!/bin/bash
echo "Libellule Installation"
dir_install="/var/www/libellule/"

echo "Check prerequisites"
#echo import sys; print(sys.version)" | python | head -n1 | awk '{print $1}'
#echo sqlite -v
sudo apt-get -y install sqlite3 php5-sqlite

echo "Configuration"
echo "Directory Installation for Libellule (default : /var/www/libellule/) ?"
read dir_install_tmp

if [ ! -z "$dir_install_tmp" ]; then
	dir_install=${dir_install_tmp}"/"
fi

echo "Installation"
echo "Directory Installation : ${dir_install}"

if [ -d ${dir_install} ]; then
	echo "Directory ${dir_install_web} already exists"
else
	echo "Directory Creation"
	sudo mkdir -p ${dir_install}
fi

echo "Copy of content"

sudo cp -R web/* ${dir_install}/
sudo cp -R test ${dir_install}
sudo wget -O ${dir_install}/test/speedtest-cli.py https://raw.github.com/sivel/speedtest-cli/master/speedtest_cli.py

echo "Rights Management"
sudo chown -R www-data. ${dir_install}
sudo chmod +x ${dir_install}/test/speedtest-cli.py

echo "Cron installation"
sudo crontab -l > cron_backup
cp cron_backup new_cron
#echo new cron into cron file
echo "00 03 * * * /var/www/libellule/test/libellule.sh" >> new_cron
#install new cron file
sudo crontab new_cron
rm new_cron

echo "Installation finished, enjoy :)"
