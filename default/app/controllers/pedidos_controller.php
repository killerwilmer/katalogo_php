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
Load::models("prueba","pedido","productopedido","misproductos");

class PedidosController extends AppController {

    //put your code here
    function index() {
        $pr = new Pedido();
        $this->arr = array();
        $this->arr = $pr->find("order ASC");
       
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
         
         if ($p->save()) {
            //si lo graba bien entrega el id del registro guardado 
            //sirve para indicar al vendedor y para grabar los productos
            $this->arr = array("resultado" => $p->id);
        } else {
            $this->arr = array("resultado" => "fracaso");
        }
         
        
    }
    
    function ajaxproductopedido(){
        View::response("view");
        $var = Input::post("pedido_id");
        $p = new Productopedido();
        $this->prods = array();
        $this->prods = $p->find("pedido_id=$var");
    }

}

?>
