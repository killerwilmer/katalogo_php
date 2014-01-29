<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
class IndexController extends ApplicationController {

    public function index() {
        if (!Auth::is_valid()) {
            $this->redirect("sesion/index");
        }
    }

}
