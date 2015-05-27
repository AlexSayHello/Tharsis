<?php
require_once(dirname(__FILE__)  . '\vendor\doctrine\orm\bin\doctrine.php');
spl_autoload_register(array('Doctrine',  'autoload'));

$conn  =  Doctrine_Manager::connection('mysql://root:@localhost/tharsis_deb',  'doctrine');
Doctrine_Core::generateModelsFromDb('app/models',  array('doctrine'), array('generateTableClasses' => true));
