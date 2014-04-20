#!/bin/bash"
#killer
sqlite3 /var/www/sqlite/dbs/aux.db <<!
DELETE FROM "main"."cliente";
.separator ,
.import /var/www/katalogo_php/default/app/test/sqlite/csvs/clientes.csv cliente
.exit
 !>>
