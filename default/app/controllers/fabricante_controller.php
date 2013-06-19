<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fabricante_controller
 *
 * @author hidden
 */
class FabricanteController extends ScaffoldController {

    //put your code here
    public $model = 'fabricante';
    public $scaffold = 'killer';

    function crear() {
        $bd = Conexion::devolverCon();

        if (Input::hasPost("nombre")) {
            $nombre = Input::post('nombre');
            if ($nombre != "") {
                $activo = 1;
                $fecha = Timestamp::getTimeStamp();

                $bd->exec("INSERT INTO fabricante(nombre, activo,fec) VALUES('" . $nombre . "', " . $activo . ", '" . $fecha . "')");
                Flash::valid('Fabricante registrado exitosamente...!!!');
            }
            else{
                Flash::error('Falta digitar el nombre del fabricante...!!!');
            }
        }
    }

}

?>
