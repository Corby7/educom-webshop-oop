<?php

include_once "../models/crud.php";
include_once "../models/usercrud.php";

$crud = new Crud();
$usercrud = new UserCrud();
$usercrud->setCrud($crud);

function getId($id) {
    global $crud;
    $sql = "SELECT * FROM test WHERE id = :id";
    $params = ['id' => $id];
    echo "params: "; var_dump($params);
    return $crud->getAll($sql, $params);
}

function updatePass($id, $password) {
    global $usercrud;
    $sql = "INSERT INTO test (name, brand) VALUES (:name, :brand)";
    $params = ['name' => $name, 'brand' => $brand];
    echo "params: "; var_dump($params);
    return $crud->createRow($sql, $params);
}



var_dump($usercrud->createUser("jo"));



?>