<?php

class UserCrud {

    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createUser($user) {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $params = $user;
        return $this->crud->createRow($sql, $params);

    }

    public function readUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $params = ['email' => $email];
        return $this->crud->readOneRow($sql, $params);
    }

    public function updateUserPassword($id, $newPassword) {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $params = ['id' => $id, 'password' => $newPassword];
        $this->crud->updateRow($sql, $params);
    }
}

?>