<?php

session_start();
require_once('controllers/pagecontroller.php');
require_once('cruds/crud.php');
require_once('factories/crudfactory.php');
require_once('factories/modelfactory.php');

$crud = new Crud();
$crudFactory = new CrudFactory($crud);
$modelFactory = new ModelFactory($crudFactory);

$controller = new PageController($modelFactory);
$controller->handleRequest();

?>

