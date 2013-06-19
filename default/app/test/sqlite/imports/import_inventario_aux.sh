#!/bin/bash"
#killer
sqlite3 /var/www/katalogokumbia/default/app/test/sqlite/dbs/aux.db <<!
DELETE FROM "main"."inventario";
.separator ,
.import /var/www/katalogokumbia/default/app/test/sqlite/csvs/inventario.csv inventario
DROP TABLE IF EXISTS misproductos;
CREATE TABLE misproductos AS SELECT p.idproducto,descripcion,precio01,precio02,precio03,precio04,iva,medida,marca,referencia,bodega,fechacompra from producto p inner join inventario i on p.idproducto=i.idproducto;
DELETE FROM "main"."inventario";
DELETE FROM "main"."producto";
.exit
!>>
