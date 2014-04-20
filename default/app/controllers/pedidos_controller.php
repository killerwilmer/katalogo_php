<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pedidos_controller
 *
 * @author usuario
 */
Load::models("prueba");
class PedidosController extends AppController {
    //put your code here
    function index(){
        $pr = new Prueba();
        $pr->find_first(1);
        Flash::valid($pr->dato);
    }
    
    function grabar(){
        
        
            $this->post = $_POST[0];
            
        
        }
}

?>
