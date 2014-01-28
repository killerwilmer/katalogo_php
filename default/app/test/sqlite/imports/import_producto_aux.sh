#!/bin/bash"
#killer
sqlite3 /var/www/sqlite/dbs/aux.db <<!
DELETE FROM "main"."producto";
.separator ,
.import /var/www/katalogo_php/default/app/test/sqlite/csvs/productos.csv producto
.exit
!>>
