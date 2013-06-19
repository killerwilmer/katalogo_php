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

/**
 * Carga del modelo Menus...
 */
Load::models('fabricante');

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
            } else {
                Flash::error('Falta digitar el nombre del fabricante...!!!');
            }
        }
    }

    /**
     * Edita un Registro
     *
     * @param int $id (requerido)
     */
    public function editar($id) {
        $fabricante = new Fabricante();

        //se verifica si se ha enviado el formulario (submit)
        if (Input::hasPost('fabricantes')) {
            
            $fabricante->fec = Timestamp::getTimeStamp();
            if ($fabricante->update(Input::post('fabricantes'))) {
                Flash::valid('Operación exitosa');
                //enrutando por defecto al index del controller
                return Router::redirect();
            } else {
                Flash::error('Falló Operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->fabricantes = $fabricante->find_by_id((int) $id);
        }
    }

}

?>
