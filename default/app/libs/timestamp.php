<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of timestamp
 *
 * @author cristhianlombana
 */
class Timestamp {
    //put your code here
    static function getTimeStamp(){
        
        date_default_timezone_set("UTC");
        
        $db = Conexion::devolverCon();
        $result = $db->query("SELECT strftime('%s','now','localtime') as tiempo");
        
        while($res = $result->fetchArray(SQLITE3_ASSOC)){
            $fecha = $res["tiempo"];
        }
        
        return $fecha;
    }
}

?>
