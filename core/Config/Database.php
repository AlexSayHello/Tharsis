<?php namespace Core\Config;

class Database {

    private static $config = Array (
        "host" => "",
        "database" => "",
        "username" => "",
        "password" => "",
    );

    public static function setConfig ( $config = Array () ) {
        self::$config = $config;
    }

    public static function getConfig () {
        return self::$config;
    }

}