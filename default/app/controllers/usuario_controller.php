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
/**
 * Carga del modelo Categorias...
 */
Load::models('usuario');

class UsuarioController extends ScaffoldController {

    //put your code here
    public $model = "usuario";
    public $scaffold = 'killer';

}

?>
