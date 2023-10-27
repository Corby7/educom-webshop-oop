<?php

//extends pagemodel for sessionmanager and geturlvar/postvar functions?
class AjaxController {

    private $modelFactory;
    private $ratingCrud;

    public $isPost = false;

    public function __construct($modelFactory) {
        $this->modelFactory = $modelFactory;
        $this->ratingCrud = $this->modelFactory->crudFactory->createCrud('rating');
    }

    public function test($rating) {
        // echo "rating: " .$rating;
    }

    protected function getPostVar($key, $default = "") {
        $value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
        return isset($value) ? $value : $default;
    }

    protected function getUrlVar($key, $default = "") {
        $value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
        return isset($value) ? $value : $default;
    }

    public function processRequest() {
        $this->isPost = ($_SERVER['REQUEST_METHOD'] == 'POST');
        $this->handleActions();
    }
    

    public function handleActions() {
        $function = $this->getUrlVar("function");
        $productId = $this->getUrlVar("id");

        if ($this->isPost) {
            $rating = $this->getUrlVar("rating");
        }

        // echo "function :" . $function;
        // echo "productid :" . $productId;
        // echo "rating :" . $rating;

        switch($function) {

            case 'getRating':

                // echo $productId;
                $result = $this->ratingCrud->getProductRating($productId);
                echo $result->average;
                break;

            case 'updateRating':
                $userId = ($_SESSION['userid']); //tijdelijk moet anders!
                // echo "userid :" . $userId;
                // echo "productid :" . $productId;
                // echo "rating :" . $rating;
                $exists = $this->ratingCrud->ratingExists($productId, $userId);
                if ($exists->result == '1') {
                    $this->ratingCrud->updateProductRating($productId, $userId, $rating);
                } else {
                    $this->ratingCrud->saveProductRating($productId, $userId, $rating);
                }
                break;

            default:
                echo 'default';
                break;
        }
    }   

}
?>