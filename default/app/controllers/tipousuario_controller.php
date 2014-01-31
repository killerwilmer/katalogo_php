<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipousuario_controller
 *
 * @author hidden
 */
/**
 * Carga del modelo tipousuario...
 */
Load::models('tipousuario');

class TipousuarioController extends ScaffoldController {
    
    public function index($page = 1) {
        if (!Auth::is_valid()) {
            Router::redirect("sesion/index");
        }
        parent::index($page);
    }

    //put your code here
    public $model = "tipousuario";
    public $scaffold = 'killer';

    /**
     * Crea un Registro
     */
    public function crear() {
        
        if (!Auth::is_valid()) {
            Router::redirect("sesion/index");
        }
        
        /**
         * Se verifica si el usuario envio el form (submit) y si ademas 
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los 
         * datos enviado por POST utilizando autocarga de objeto
         */
        if (Input::hasPost('tipousuarios')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $tipousuario = new tipousuario(Input::post('tipousuarios'));
            //En caso que falle la operación de guardar

            $tipousuario->activo = 1;
            $tipousuario->fechaactualizacion = Timestamp::getTimeStamp();
            if ($tipousuario->save()) {
                Flash::valid('Operación exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return;
            } else {
                Flash::error('Falló Operación');
            }
        }
    }

    /**
     * Edita un Registro
     *
     * @param int $id (requerido)
     */
    public function editar($id) {
        
        if (!Auth::is_valid()) {
            Router::redirect("sesion/index");
        }
        
        $tipousuario = new tipousuario();

        //se verifica si se ha enviado el formulario (submit)
        if (Input::hasPost('tipousuarios')) {

            $tipousuario->activo = 1;
            $tipousuario->fechaactualizacion = Timestamp::getTimeStamp();
            if ($tipousuario->update(Input::post('tipousuarios'))) {
                Flash::valid('Operación exitosa');
                //enrutando por defecto al index del controller
                return Router::redirect();
            } else {
                Flash::error('Falló Operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->tipousuarios = $tipousuario->find_by_id((int) $id);
        }
    }

}

?>
