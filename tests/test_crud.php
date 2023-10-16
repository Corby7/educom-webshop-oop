<?php

include_once "../models/crud.php";

$crud = new Crud();

function getId($id) {
    global $crud;
    $sql = "SELECT * FROM test WHERE id = :id";
    $params = ['id' => $id];
    echo "params: "; var_dump($params);
    return $crud->getAll($sql, $params);
}

function addRow($name, $brand) {
    global $crud;
    $sql = "INSERT INTO test (name, brand) VALUES (:name, :brand)";
    $params = ['name' => $name, 'brand' => $brand];
    echo "params: "; var_dump($params);
    return $crud->createRow($sql, $params);
}

function readRow($name) {
    global $crud;
    $sql = "SELECT * FROM test WHERE name = :name";
    $params = ['name' => $name];
    echo "params: "; var_dump($params);
    return $crud->readOneRow($sql, $params);
}

function readRows($name1, $name2) {
    global $crud;
    $sql = "SELECT * FROM test WHERE name IN (:name1, :name2)";
    $params = ['name1' => $name1, 'name2' => $name2];
    echo "params: "; var_dump($params);
    return $crud->readManyRows($sql, $params);
}

var_dump(readRows("Polo", "Tonale"));

// var_dump(readRow("Polo"));

// var_dump(addRow("Tonale", "Alfa-Romeo"));

// var_dump($crud->getId());

// var_dump(getId("3"));


?>