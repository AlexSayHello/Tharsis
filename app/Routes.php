<?php namespace App;

/*-----------------------------------------------------------------------------
|                               Archivo de rutas
|------------------------------------------------------------------------------
|
|   En este archivo se declaran las rutas y los controladores y acciones con
|   con las que debera responder la aplicacion.
|   Para saber mas sobre las rutas acudir a la documentacion de la app
|
|------------------------------------------------------------------------------*/

$router->get("","Home@index");
$router->get("home","Home@user");


