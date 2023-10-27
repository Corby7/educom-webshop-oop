<?php

class RatingCrud {

    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function saveProductRating($productId, $userId, $rating) {
        $sql = "INSERT INTO ratings (user_id, product_id, rating) VALUES (:user_id, :product_id, :rating)";
        $params = ['user_id' => $userId, 'product_id' => $productId, 'rating' => $rating];
        return $this->crud->createRow($sql, $params);
    }

    public function getProductRating($productId) {
        $sql = "SELECT ROUND(AVG(rating), 0) AS average FROM ratings WHERE product_id = :product_id";
        $params = ['product_id' => $productId];
        return $this->crud->readOneRow($sql, $params);
    }

    public function ratingExists($productId, $userId) {
        $sql = "SELECT CASE WHEN EXISTS (SELECT 1 FROM ratings WHERE product_id = :product_id AND user_id = :user_id) THEN 1 ELSE 2 END AS result";
        $params = ['product_id' => $productId, 'user_id' => $userId];
        return $this->crud->readOneRow($sql, $params);
    }

    public function updateProductRating($productId, $userId, $rating) {
        $sql = "UPDATE ratings SET rating = :rating WHERE product_id = :product_id AND user_id = :user_id";
        $params = ['rating' => $rating,'product_id' => $productId, 'user_id' => $userId];
        return $this->crud->updateRow($sql, $params);
    }


    //SELECT id, user_id, product_id, ROUND(AVG(rating), 0) AS average FROM `ratings` GROUP BY product_id; 

    public function getAllRatings($productIds) {}

}

?>