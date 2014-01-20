sqlite3 libellule.db "drop table ping;"
sqlite3 libellule.db "drop table download;"
sqlite3 libellule.db "drop table upload;"
sqlite3 libellule.db "create table ping(point INTEGER PRIMARY KEY, value INTEGER);"
sqlite3 libellule.db "create table download(point INTEGER PRIMARY KEY, value INTEGER);"
sqlite3 libellule.db "create table upload(point INTEGER PRIMARY KEY, value INTEGER);"

