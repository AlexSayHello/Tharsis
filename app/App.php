<?php namespace App;

/*-----------------------------------------------------------------------------
|   App - Objeto principal - Envoltorio de la aplicacion
|------------------------------------------------------------------------------
|   La clase App permite crear el objeto envoltorio, es decir, el
|   mecanismo que inicia el sistema y desencadena los eventos y acciones.
|
|   Desde este objeto se incializan todos los componentes necesarios para
|   el funcionamiento del sistema.
|
|--------------------------------+--------------------------------------------*/

use Core\Http\BaseController;
use Core\Http\Request;
use Core\Http\Router;
use Core\Responses\View;

class App {

    public function __construct () {
        /*---------------------------------------------------------------------
        |   Inicializacion del objeto View
        |----------------------------------------------------------------------
        |   Inicilizacion del objeto correspondiente a la vista, la
        |   respuesta encarga de enviar los datos al usuario.
        |--------------------------------------------------------------------*/
        $smarty = new \Smarty();
        $view = new View( $smarty );




        /*---------------------------------------------------------------------
        |   Inicializacion del objeto Request
        |----------------------------------------------------------------------
        |   Inicio del objeto Request que manejara la petición del
        |   del usuario.
        |--------------------------------------------------------------------*/
        $request = new Request();





        /*---------------------------------------------------------------------
        |   Inicializacion del objeto Router
        |----------------------------------------------------------------------
        |   Inicio del enrutador de peticiones, el cual recibe el objeto
        |   request y se encarga de identificar el controlador solicitado
        |   y de arrancarlo.
        |--------------------------------------------------------------------*/
        $router = new Router( $request , $view );
        require "Routes.php";
    }

}