<?php namespace Core\Http;

/*---------------------------------------------------------
||           REQUEST - Manejador de peticiones
||---------------------------------------------------------
||
||  Clase perteneciente al nucleo del sistema, se encar-
||  de recibir e interpretar las peticiones Http enviad-
||  as mediante URL por medio de GET, su resultado sera-
||  el controlador y accion que corresponde con el even-
||  to solicitado
||
||---------------------------------------------------------*/

class Request {

    private $url;
    private $params;

    public function __construct () {
        $this->url = $_GET["url"];

        $this->params = explode( "/" , $this->url );
    }

    public function getUrl () {
        return $this->url;
    }

    public function getParams () {
        return $this->params;
    }

    public function getController () {
        return $this->getParams()[0];
    }

    public function getAction () {
        return $this->getParams()[1];
    }

    /* ===========================================================
     * Retorna un array con los parametros o argumentos  opcionales
     * pasados por la URL, en caso de no  haber  pasado  parametros
     * el           metodo               devolvera            falso.
     *------------------------------------------------------------
     * @return array|bool
     *============================================================*/
    public function getArguments () {

        $params = array_slice( $this->getParams() , 2 );

        if ( count ( $params ) == 0 )  {
            return false;
        }

        else {
            return $params;
        }
    }

}