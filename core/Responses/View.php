<?php namespace Core\Responses;

use Core\Http\Response;
use Smarty;

class View extends Response {

    private $engine;
    private $template;

    public function __construct ( Smarty $smarty ) {

        $this->engine = $smarty;
        $this->engine->template_dir = "../app/views";


    }

    public function execute () {
       $this->engine->assign("probando","Hola que tal");
       $this->engine->display("home.tpl");

    }

}