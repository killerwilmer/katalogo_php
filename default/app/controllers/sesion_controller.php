<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sesion_controller
 *
 * @author wilmerarteaga
 */

View::template("sesion/logueo");
class SesionController extends AppController {

    function index() {
        if (Input::hasPost("identificacion")) {
            $login = Input::post("identificacion");
            $clave = Input::post("clave");

            $auth = new Auth("model", "class: usuario", "login: $login", "clave: $clave");
            if ($auth->authenticate()) {
                $usu = new Usuario();
                $usu->find_first("login='$login' and clave='$clave'");
                if ($usu->tipousuario_id == 1) {//vendedor
                    Session::set("idproveedor", $usu->id);
                    Session::set("idtipoproveedor", $usu->tipousuario_id);
                    Router::redirect("index");
                } else if ($usu->tipousuario_id == 2) {//admin
                    Session::set("idproveedor", $usu->id);
                    Session::set("idtipoproveedor", $usu->tipousuario_id);
                    Router::redirect("asistente/editar/");
                }
            } else {
                Flash::error("Login o Clave inválido.");
            }
        }
    }

    function cerrar() {
        Auth::destroy_identity();
        Session::delete("idproveedor");
        Session::delete("idtipoproveedor");
        Router::redirect("sesion/index");
    }

}

?>