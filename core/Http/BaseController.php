<?php namespace Core\Http;

use Core\Responses\View as View;

class BaseController {

    protected  $view;

    public function __construct ( View $view ) {
        $this->view = $view;
    }


}