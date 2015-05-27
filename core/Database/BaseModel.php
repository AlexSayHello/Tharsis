<?php namespace Core\Database;

use Core\Config\Database;

abstract class BaseModel {

    private $config = Array();

    public function __construct () {
        require "../app/Config/Database.php";
        $this->config = Database::getConfig();
    }
}