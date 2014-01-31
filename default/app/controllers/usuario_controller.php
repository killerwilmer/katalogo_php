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
    
    public function index($page = 1) {
        if (!Auth::is_valid()) {
            Router::redirect("sesion/index");
        }
        parent::index($page);
    }

    //put your code here
    public $model = "usuario";
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
        if (Input::hasPost('usuarios')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $usuario = new Usuario(Input::post('usuarios'));
            //En caso que falle la operación de guardar

            $usuario->activo = 1;
            $usuario->fechaactualizacion = Timestamp::getTimeStamp();
            if ($usuario->save()) {
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
        
        $usuario = new Usuario();

        //se verifica si se ha enviado el formulario (submit)
        if (Input::hasPost('usuarios')) {

            $usuario->activo = 1;
            $usuario->fechaactualizacion = Timestamp::getTimeStamp();
            if ($usuario->update(Input::post('usuarios'))) {
                Flash::valid('Operación exitosa');
                //enrutando por defecto al index del controller
                return Router::redirect();
            } else {
                Flash::error('Falló Operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->usuarios = $usuario->find_by_id((int) $id);
        }
    }

}

?>
