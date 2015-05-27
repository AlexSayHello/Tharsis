<?php namespace App\Controllers;

class HomeController {

    public function indexAction () {
        include "../app/Config/Database.php";
    }

    public function userAction () {
        return "Usuarios";
    }

}