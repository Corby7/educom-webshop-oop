<?php

session_start();
require_once('controllers/pagecontroller.php');

$controller = new PageController();
$controller->handleRequest();

?>

