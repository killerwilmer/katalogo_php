<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of conexion
 *
 * @author cristhianlombana
 */
class Conexion {
    //put your code here
    static function devolverCon(){
        return new SQLite3('../app/test/sqlite/dbs/katalogo.db'); 
        
    }
    
    static function devolverPDO(){
        return new PDO('sqlite:../app/test/sqlite/dbs/katalogo.db');
    }
}

?>
