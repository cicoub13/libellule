#!/bin/bash
/var/www/libellule/test/speedtest-cli.py --simple > ./tmp_libellule
PING=`ping google.com -c 1 | sed -n "2 p" | awk '{print substr($0,length($0)-6,2)}'`
DOWNLOAD=`sed -n "2 p" ./tmp_libellule | cut -c '11-15'`
UPLOAD=`sed -n "3 p" ./tmp_libellule | cut -c '8-12'`
TIME=`date +%s`
rm ./tmp_libellule

sqlite3 libellule.db  "insert into ping (point, value) values ($TIME, $PING);"
sqlite3 libellule.db  "insert into download (point, value) values ($TIME, $DOWNLOAD);"
sqlite3 libellule.db  "insert into upload (point, value) values ($TIME, $UPLOAD);"
