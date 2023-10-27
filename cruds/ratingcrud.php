<?php

class RatingCrud {

    private $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function saveRatingProduct($productId, $UserId, $rating) {}

    public function adjustRatingProduct($productId, $userId, $rating) {}

    public function getProductRating($productId) {
        $sql = "SELECT rating FROM products WHERE id = :id";
        $params = ['id' => $productId];
        return $this->crud->readOneRow($sql, $params);
    }

    public function getAllRatings($productIds) {}

}

?>