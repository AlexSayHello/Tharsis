<?php namespace Core\Config;

class BaseConfig {

    private $config;

    public abstract function set();
    public abstract function get();

}