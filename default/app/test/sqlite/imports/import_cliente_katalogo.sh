#!/bin/bash"
#killer
sqlite3 /var/www/katalogokumbia/default/app/test/sqlite/dbs/katalogo.db <<!
DELETE FROM "main"."cliente";
.separator ,
.import /var/www/katalogokumbia/default/app/test/sqlite/csvs/clientes.csv cliente
.exit
 !>>
