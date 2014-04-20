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
Load::models("prueba","Pedido");

class PedidosController extends AppController {

    //put your code here
    function index() {
        $pr = new Prueba();
        $pr->find_first(1);
        Flash::valid($pr->dato);
    }

    function grabar($cliente_id, $usuario_id, $fechacreacion, $fechamodificacion, $estado, $nit, $observacion) {
        View::response("view");
        $ped = new Pedido();
        $ped->cliente_id = $cliente_id;
        $ped->usuario_id = $usuario_id;
        $ped->fechacreacion = $fechacreacion;
        $ped->fechamodificacion = $fechamodificacion;
        $ped->estado = $estado;
        $ped->nit = $nit;
        $ped->observacion = $observacion;

        if ($ped->save()) {
            $this->arr = array("resultado" => "exito");
        } else {
            $this->arr = array("resultado" => "fracaso");
        }
        
    }

}

?>
