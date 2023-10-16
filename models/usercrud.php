<?php

class UserCrud {

    private $crud;

    private function CreateUser($user) {

    }

    private function ReadUserByEmail($email) {

    }

    private function updateUserPassword($id, $newPassword) {
        $sql = "UPDATE ... WHERE id=::id";
        $params = ['id' => $id, 'password' => $newPassword];
        $this->crud->updateRow($sql, $params);
    }
}

?>