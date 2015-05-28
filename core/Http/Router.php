<?php namespace Core\Http;

/*-----------------------------------------------------------------------------
|                       Router - Enrutador de peticiones
|------------------------------------------------------------------------------
|   El enrutador de peticiones se encarga de recibir los datos de la
|   peticion desde Request y de  devolver  el  controlador  y  accion
|   asociados a dicha peticion
|
-------------------------------------------------------------------------------*/

use App\Controllers;
use Core\Utilities\Matrix;

class Router {

    /*-------------------------------------------------------------------------
    |   Request $request - Instancia de la clase Request
    |--------------------------------------------------------------------------
    |   La propiedad $reques almacena el objeto Request  inyectado despues
    |   de que este procese la peticion, Request es declarado por  primera
    |   vez App, el objeto contenedot.
    |--------------------------------------------------------------------------*/
    private $request;



    /*-------------------------------------------------------------------------
    |  String $path - Ruta del directorio de controladores
    |--------------------------------------------------------------------------
    |  La propiedad $path alamacena la ruta relativa de la carpeta
    |  de los controladores con respecto al  directorio ./public.
    |------------------------------------------------------------------------*/
    private $path = "../app/controllers/";



    /*-------------------------------------------------------------------------
    |   String $controller_suffix - Sufijo de nombre de controlador
    |--------------------------------------------------------------------------
    |   Propiedad que almacena el sufijo utilizado para identificar
    |   a los controladores.
    |   Ejemplo: [NombreControlador][Controller] - HomeController
    |------------------------------------------------------------------------*/
    private $controller_suffix = "Controller";



    /*-------------------------------------------------------------------------
    |   String action_suffix - Sufijo de los metodos de accion
    |--------------------------------------------------------------------------
    |   Esta propiedad almacena un string con el sufijo usado para
    |   identificar a los metodos de accion de los controladores
    |
    |   Ejemplo : indexAction = Metodo principal
    |------------------------------------------------------------------------*/
    private $action_suffix = "Action";



    /*-------------------------------------------------------------------------
    |   String $route - Ruta declarada en metodo get
    |--------------------------------------------------------------------------
    |   Esta propiedad almacena la ruta declarada en el metodo get
    |   en .app/Routes.php. El motivo de almacenar esta informacion
    |   en el objeto es facilitar su acceso global a todos los metodos.
    |------------------------------------------------------------------------*/
    private $route;



    /*-------------------------------------------------------------------------
    |   String $controller_and_action
    |--------------------------------------------------------------------------
    |   Esta propiedad alamacena el controlador y accion asocidada a
    |   la ruta declarada en el metodo get en ./app/Routes.php
    |------------------------------------------------------------------------*/
    private $controller_and_action;



    /*-------------------------------------------------------------------------
    |   Constructor - Metodo principal de la clase Router
    |--------------------------------------------------------------------------
    |   Metodo principal de la clase Router, se encarga de inicializar
    |   el objeto instanciado, su primera funcion es la de cargar
    |   el objeto Request inyectado
    |   El objeto es instanciado en ./app/App.php y llamado en
    |   ./public/index.php
    |--------------------------------------------------------------------------*/
    public function __construct ( Request $request ) {
        $this->request = $request;

    }



    /*-------------------------------------------------------------------------
    |   Metodo get - Declaracion de routes
    |--------------------------------------------------------------------------
    |   El metodo get es usado para declarar las rutas, los parametros y
    |   sus correspondiente Controladores y acciones.
    |   Este metodo se declara siempre en el archivo Routes de ./app
    |------------------------------------------------------------------------*/
    public function get ( $route = "" , $controller_and_action = "" ) {

        $this->route = $route;
        $this->controller_and_action = $controller_and_action;

        return $this->executeController();


    }



    /*-------------------------------------------------------------------------
    |   Metodo getDeclaredRoute - Obtener ruta declarada en metodo get()
    |--------------------------------------------------------------------------
    |   Este metodo devuelve un String con la ruta declarada en
    |   el metodo get, en el archivo de rutas ./app/Routes.php.
    |   Los parametros son ignorados, no se devuelven.
    |------------------------------------------------------------------------*/
    private  function getDeclaredRoute () {
        return explode( "@" , $this->route )[0];
    }



    /*-------------------------------------------------------------------------
    |   Metodo getDescomposedRoute - Devuelve ruta descompuesta
    |--------------------------------------------------------------------------
    |   Este metodo devuelve un array con la ruta declarada en get
    |   en el que cada elemento corresponde a un segmento e de la ruta
    |   separado por un (/) slash o barra inclinada
    |
    |   Ejemplo : home/perfil => ["home", "perfil"]
    |------------------------------------------------------------------------*/
    private function getDescomposedRoute () {
        return Matrix::removeEmptyString( explode( "/" ,  $this->getDeclaredRoute() ) );
    }



    /*-------------------------------------------------------------------------
    |   Metodo getDeclaredParams - Devuelve los parametros declarados en get
    |--------------------------------------------------------------------------
    |   Este metodo devuelve un string con todos los parametros declarados
    |   en el metodo get, en el archivo ./app/Routes.php
    |------------------------------------------------------------------------*/
    private function getDeclaredParams () {
        if ( count ( $params =  explode( "@" , $this->route ) ) == 1 )
        {
            return false;
        }

        else
        {
            return $params[1];
        }

    }



    /*-------------------------------------------------------------------------
    |   Metodo getDeclaredParamsArray
    |--------------------------------------------------------------------------
    |   Devuelve un Array con todos los parametros de URL declarados
    |   en el metodo get del archivo ./app/Routes.php
    |------------------------------------------------------------------------*/
    private function getDeclaredParamsArray () {
        return Matrix::deleteSignKey( explode( "/" , $this->getDeclaredParams() ) );
    }



    /*-------------------------------------------------------------------------
    |   Metodo getRequestURL - Retorna URL de la peticion
    |   Retorna Array
    |--------------------------------------------------------------------------
    |   Devuelve un array con todos los segmentos de la url
    |   correctamente formateados
    |
    |   Ejemplo: ["Usuario","Perfil","Alejandro"]
    |------------------------------------------------------------------------*/
    private function getRequestURL () {
        return Matrix::removeEmptyString( $this->request->getParams() );
    }



    /*-------------------------------------------------------------------------
    |   Metodo routesMacth - Comprobacion de coincidencia de rutas.
    |--------------------------------------------------------------------------
    |   Este metodo comprueba si la ruta pedida a traves de Request
    |   coincide con la ruta declarada en el metodo get(), en el
    |   archivo .app/Routes.php.
    |   Si coinciden el metodo devolvera verdadero(true), de lo
    |   contrario devolvera falso.
    |------------------------------------------------------------------------*/
    private function routesMatch () {

        if ( count( $this->getDescomposedRoute() ) != count( $this->getRequestURL() ) )
        {
           return false;
        }

        else
        {
            $match = 0;

            foreach ( $this->getDescomposedRoute() as $declared_index=>$declared_element )
            {
                foreach ( $this->getRequestURL() as $request_index=>$request_element )
                {
                    if ( $declared_element === $request_element ) {
                        $match++;
                    }
                }
            }

            if ( $match == count( $this->getDescomposedRoute() ) ) {
                return true;
            }
        }

    }



    /*-------------------------------------------------------------------------
    |   Metodo getController - Obtiene controlador declarado
    |--------------------------------------------------------------------------
    |   Este metodo retorna el controlador declarado en el metodo get
    |   en el archivo de rutas de ./app/Routes.php
    |------------------------------------------------------------------------*/
    private function getController () {
        return explode( "@" , $this->controller_and_action )[0];
    }



    /*-------------------------------------------------------------------------
    |   Metodo getControllerName - Nombre completo del metodo
    |--------------------------------------------------------------------------
    |   Este metodo retonar el nombre completo del controlador, incluyendo
    |   el sufijo estandar declarado en la propiedad $controller_siffix
    |------------------------------------------------------------------------*/
    private function getControllerName () {
        return $this->getController() . $this->controller_suffix;
    }



    /*-------------------------------------------------------------------------
    |   Metodo getAction - Nombre de la accion declarada en get
    |--------------------------------------------------------------------------
    |   Este metodo retorna el nombre completo de la accion declarada en
    |   en el metodo get, en el archivo ./app/Routes.php.
    |
    |   El nombre de la acción se corresponde con el metodo al que debe
    |   invocar el enrutador en su correspondiente controlador.
    |------------------------------------------------------------------------*/
    private function getAction ( ) {
        return explode( "@" , $this->controller_and_action )[1] . $this->action_suffix;
    }

    /*-------------------------------------------------------------------------
    |   Metodo ControllerExists - Existencia del controlador
    |--------------------------------------------------------------------------
    |   Este metodo comprueba si existe el controlador declarado en el
    |   metodo get, en el archivo ./app/Routes.php.
    |
    |   Para ello hace una busqueda en el directorio ./app/controllers/
    |   Si el archivo que contiene el controlador existe, el archivo
    |   retornara true, en caso contrario retornara falso.
    |------------------------------------------------------------------------*/
    private function controllerExists ( ) {
        return file_exists( $this->getControllerFullPath() );
    }



    /*-------------------------------------------------------------------------
    |   Metodo controllerClassExists - Existencia de la clase controladora
    |--------------------------------------------------------------------------
    |   Este metodo comprueba la existencia de la clase asociada al
    |   controlador solicitado, si esta existe retornara true, de
    |   contrario retonara false.
    |------------------------------------------------------------------------*/
    private function controllerClassExists () {
        return class_exists("\\App\\Controllers\\" . $this->getControllerName());
    }



    /*-------------------------------------------------------------------------
    |   Metodo controllerActionExists - Existencia de la accion
    |--------------------------------------------------------------------------
    |   Este metodo comprueba la existencia del metodo correspondiente a la
    |   accion declarada.
    |------------------------------------------------------------------------*/
    private function controllerActionExists ( $controller_object ) {
        return method_exists( $controller_object , $this->getAction() );
    }



    /*-------------------------------------------------------------------------
    |   Metodo getControllerFullPath - Ruta completa del controlador
    |--------------------------------------------------------------------------
    |   Este metodo retorna la ruta completa que alberga el archivo
    |   de la clase correspondiente al controlador solicitado.
    |------------------------------------------------------------------------*/
    private function getControllerFullPath () {
        return $this->path . $this->getController() . $this->controller_suffix . ".php";
    }



    /*-------------------------------------------------------------------------
    |   Metodo validateRequest - Validacion de la peticion
    |--------------------------------------------------------------------------
    |   Este metodo comprueba y valida que todos los pametros
    |   de la peticion sean correctos y coincidan.
    |------------------------------------------------------------------------*/
    private function validateRequest () {

        if ( $this->routesMatch() )
        {
            if ( $this->controllerExists () )
            {
                if ( $this->controllerClassExists() )
                {
                    return true;
                }
            }
        }

    }



    /*-------------------------------------------------------------------------
    |   Metodo executeController - Ejecucion del controlador
    |--------------------------------------------------------------------------
    |   Una vez comprobada la validez de la peticion y que todos los
    |   parametros coincidan, se crea una instancia de la clase
    |   asociada al controlador y despues se ejecuta el
    |   metodo asociado a la accion
    |------------------------------------------------------------------------*/
    private function executeController () {
        if ( $this->validateRequest() )
        {
            $class = "App\\Controllers\\" . $this->getControllerName();
            $controller = new $class();

            /* REVISAR:
             * La comprobacion de la existencia del metodo debe realizarse
             * fuera del metodo de ejecuacion del mismo.
             */
            if ( $this->controllerActionExists( $controller ) )
            {
                $action = $this->getAction();
                $controller->$action();
            }
        }
    }

}