#!/bin/bash
echo "Initalization of SQLite"
if [ "$#" -ne 1 ]; then 
    echo "Usage : ./initialize.sh dir_install"
else
	echo "Start of initialization"
	sqlite3 $1/test/libellule.db "drop table if exists ping;"
	sqlite3 $1/test/libellule.db "drop table if exists download;"
	sqlite3 $1/test/libellule.db "drop table if exists upload;"
	sqlite3 $1/test/libellule.db "create table ping(point INTEGER PRIMARY KEY, value INTEGER);"
	sqlite3 $1/test/libellule.db "create table download(point INTEGER PRIMARY KEY, value INTEGER);"
	sqlite3 $1/test/libellule.db "create table upload(point INTEGER PRIMARY KEY, value INTEGER);"
	echo "Initalization done"
fi
