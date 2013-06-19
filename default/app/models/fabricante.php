<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fabricante
 *
 * @author cristhianlombana
 */
class Fabricante extends ActiveRecord {
//put your code here
    protected function initialize(){
        $this->validates_presence_of("nombre", "Falta digitar el nombre");
    }
}

?>
