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
Load::models("prueba","pedido");

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
            //si lo graba bien entrega el id del registro guardado 
            //sirve para indicar al vendedor y para grabar los productos
            $this->arr = array("resultado" => $ped->id);
        } else {
            $this->arr = array("resultado" => "fracaso");
        }
        
    }
    
    //el pedido_id que ingresa es el de mysql porque ya se tiene que relacionar con ese id de pedido en el servidor
    function grabarproducto($producto_id,$pedido_id,$cantidad,$descuento1,$descuento2,$precio,$observacion){
         View::response("view");
         $p = new Productopedido();
         $p->producto_id=$producto_id;
         $p->pedido_id=$pedido_id;
         $p->cantidad=$cantidad;
         $p->descuento1=$descuento1;
         $p->descuento2=$descuento2;
         $p->precio=$precio;
         $p->observacion=$observacion;
         
         $p->save();
         
        
    }

}

?>
