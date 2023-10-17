<?php

class Crud {

    private $pdo;

    private function connectDB() {
        $servername = "localhost";
        $dbname = "corbijns_webshop";
        $username = "WebShopUser";
        $password = "1234";
        $connectionString = "mysql:server=$servername;dbname=$dbname";

        $this->pdo = new PDO($connectionString, $username, $password);
        $this->pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createRow($sql, $params=[]) {
        $this->connectDB();
        
        try {
            $stmt = $this->pdo->prepare($sql);
            //not sure if foreach is really necessary for onerow actions?
            foreach ($params as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            $stmt->execute();
            $result = $this->pdo->lastInsertId();
            echo "Row succesfully created";
            return $result;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function readOneRow($sql, $params=[]) {
        $this->connectDB();
        
        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            echo "Row succesfully read";
            return $result;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function readManyRows($sql, $params=[]) {
        $this->connectDB();
        
        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo "Rows succesfully read";
            return $result;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateRow($sql, $params=[]) {
        $this->connectDB();

        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            $stmt->execute();

            echo "Row updated succesfully";
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    protected function deleteRow($sql, $params=[]) {}


}

?>