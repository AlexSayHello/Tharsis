<?php namespace App\Controllers;

use Core\Http\BaseController;

class HomeController extends BaseController {

    public function indexAction () {
        $this->view->execute();
    }

    public function userAction () {
        return "Usuarios";
    }

}