<?php namespace App\Controllers;

class HomeController {

    public function indexAction () {
        echo "Hola";
    }

    public function userAction () {
        return "Usuarios";
    }

}