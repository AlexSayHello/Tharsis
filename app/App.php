<?php namespace App;

use Core\Http\Request;
use Core\Http\Router;

class App {

    public function __construct () {
        /*
         * Inicializacion del manejador de peticiones
         */
        $request = new Request();


        /*
         * Inicializacion del enrutador de peticiones
         */
        $router = new Router( $request );
        require "Routes.php";
    }

}