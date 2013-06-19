<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario_controller
 *
 * @author hidden
 */
class UsuarioController extends ApplicationController {

    //put your code here
    function index() {
        $bd = Conexion::devolverCon();
        $this->result = $bd->query("
            select * from usuario ");

        if (Input::hasPost("categoria")) {
            $this->redirect("imagen/index/" . Input::post("categoria"));
        }
    }

}

?>
