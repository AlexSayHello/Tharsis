<?php

/*-----------------------------------------------------------------------------
||                  Frontend Controller - Punto de acceso
||-----------------------------------------------------------------------------
||
||  El archivo index.php del directorio ./public es el archivo primario
||  de la app este archivo es el primero en ser llamado cuando
||  se accede a la app  y se solicita un recurso, es el  unico punto
||  de acceso que  posee la
||  aplicacion, todas  las peticiones  realizadas son redirigidas  hacia
||  hacia el.
||
||  Cuando se  carga  este  archivo se  incializa la apliacion, se cargan
||  las  clases   necesarias  y   finalmente  se llama  al  manejador  de
||  peticiones.
||
||-----------------------------------------------------------------------------*/

require "../vendor/autoload.php";
use App\App;


$app = new App();

