<?php

class ShopCrud {

    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

   public function getProduct($productid) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $params = ['id' => $productid];
        return $this->crud->readOneRow($sql, $params);
    }

    public function getProductsByIds(array $productids) {
        $productidsString = implode(',', $productids);
        $sql = "SELECT * FROM products WHERE id IN (:ids)";
        $params = ['ids' => $productidsString];
        return $this->crud->readManyRows($sql, $params);
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $params = [];
        return $this->crud->readManyRows($sql, $params);
    }

    public function getTopFiveProducts() {
        $sql = "SELECT orderlines.product_id, SUM(orderlines.amount), orders.date, products.id, products.name, products.price, products.filenameimage 
        FROM orderlines
        LEFT JOIN orders ON orderlines.order_id = orders.id 
        LEFT JOIN products ON orderlines.product_id = products.id
        WHERE orders.date > DATE_SUB(NOW(), INTERVAL 2 WEEK)
        GROUP BY orderlines.product_id 
        ORDER BY SUM(orderlines.amount) 
        DESC LIMIT 5";
        //change 2 week back to 1 week later!!
        $params = [];
        return $this->crud->readManyRows($sql, $params);
    }
   
   
   
   
   
   
   
   
    public function createUser($user) {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $params = $user; // $user as['name' => $username, 'email' => $email , 'password' => $pass,];
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