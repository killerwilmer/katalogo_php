<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoria_controller
 *
 * @author hidden
 */
/**
 * Carga del modelo Categorias...
 */
Load::models('categoria');

class CategoriaController extends ScaffoldController {

    //put your code here
    public $model = "categoria";
    public $scaffold = 'killer';

    /**
     * Crea un Registro
     */
    public function crear() {
        /**
         * Se verifica si el usuario envio el form (submit) y si ademas 
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los 
         * datos enviado por POST utilizando autocarga de objeto
         */
        if (Input::hasPost('categorias')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $categoria = new Categoria(Input::post('categorias'));
            //En caso que falle la operación de guardar
            
            $categoria->activo = 1;
            $categoria->fechaactualizacion = Timestamp::getTimeStamp();
            if ($categoria->save()) {
                Flash::valid('Operación exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return;
            } else {
                Flash::error('Falló Operación');
            }
        }
    }

}

?>
