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

    public function getProductsByIds($productids) {
        $sql = "SELECT * FROM products WHERE id IN (:ids)";
        $params = array("ids" => $productids);
        $result = $this->crud->prepareAndBind($sql, $params);
        $sqlPrepped = $result["sql"];
        $paramsPrepped = $result["params"];
        return $this->crud->readManyRows($sqlPrepped, $paramsPrepped, true);
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
        WHERE orders.date > DATE_SUB(NOW(), INTERVAL 1 WEEK)
        GROUP BY orderlines.product_id 
        ORDER BY SUM(orderlines.amount) 
        DESC LIMIT 5";
        $params = [];
        return $this->crud->readManyRows($sql, $params);
    }

    public function createOrder($userId, $cart) {
        $sql = "INSERT INTO orders (user_id, `date`) VALUES (:id, CURRENT_TIMESTAMP())";
        $params = ['id' => $userId];
        $orderid = $this->crud->createRow($sql, $params);
        foreach ($cart as $productid => $amount) {
            $sql = "INSERT INTO orderlines (order_id, product_id, amount) VALUES (:orderid, :productid, :amount)";
            $params = ['orderid' => $orderid, 'productid' => $productid, 'amount' => $amount];
            $this->crud->createRow($sql, $params);
        }
    }

}

?>