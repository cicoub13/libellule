#!/bin/bash
speedtest-cli --json > /tmp/results.json
DOWNLOAD=$(cat /tmp/results.json | jq '.download')
UPLOAD=$(cat /tmp/results.json | jq '.upload')
PING=$(cat /tmp/results.json | jq '.ping')

node /home/pi/libellule/upload_mesure.js $DOWNLOAD $UPLOAD $PING
rm /tmp/results.json