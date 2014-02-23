#!/bin/bash
echo "Libellule Installation"
dir_install="/var/www/libellule/"

echo "Check prerequisites"
echo "import sys; print(sys.version)" | python | head -n1 | awk '{print $1}'

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
	mkdir -p ${dir_install}
fi

echo "Copy of content"

cp -R web/* ${dir_install}/
cp -R test ${dir_install}
wget -O ${dir_install}/test/speedtest-cli https://raw.github.com/sivel/speedtest-cli/master/speedtest_cli.py

echo "Rights Management"
chown -R www-data. ${dir_install}
chmod +x ${dir_install}/test/speedtest-cli

echo "Installation finished, enjoy :)"
