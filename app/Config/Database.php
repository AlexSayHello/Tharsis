<?php namespace App\Config;

use Core\Config\Database;

Database::setConfig( Array (
    "host" => "localhost",
    "database" => "db",
    "user" => "foo",
    "pass" => "bar"
) );

Database::getConfig();