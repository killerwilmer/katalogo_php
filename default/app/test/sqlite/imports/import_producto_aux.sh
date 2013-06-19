#!/bin/bash"
#killer
sqlite3 /var/www/katalogokumbia/default/app/test/sqlite/dbs/aux.db <<!
DELETE FROM "main"."producto";
.separator ,
.import /var/www/katalogokumbia/default/app/test/sqlite/csvs/productos.csv producto
.exit
 !>>
