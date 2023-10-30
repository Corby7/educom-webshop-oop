<?php

class AjaxController {

    private $modelFactory;
    private $model;
    private $ratingCrud;

    public function __construct($modelFactory) {
        $this->modelFactory = $modelFactory;
        $this->model = $this->modelFactory->createModel('page');
        $this->ratingCrud = $this->modelFactory->crudFactory->createCrud('rating');
    }

    public function handleRequest() {
        $this->getRequest();
        $this->processRequest();
        //$this->showResponse();
        }
 
    //from client
    private function getRequest() {
        $this->model->getRequestedPage();
    }    

    public function processRequest() {
        $this->handleActions();
    }
    

    public function handleActions() {
        $function = $this->model->getUrlVar("function");
        $productId = $this->model->getUrlVar("id");

        if ($this->model->isPost) {
            $rating = $this->model->getUrlVar("rating");
        }

        switch($function) {

            case 'getRating':
                $result = $this->ratingCrud->getProductRating($productId);
                $result = array($result);
                echo $this->toJSON($result);
                break;
            
            case 'getAllRatings':
                $result = $this->ratingCrud->getAllRatings();
                echo $this->toJSON($result);
                break;


            case 'updateRating':
                $userId = $this->model->sessionManager->getLoggedInUserId();
                
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

    public function toJSON($result) {
        $jsonArray = array();
    
        foreach ($result as $product) {
            $productData = array(
                "id" => $product->product_id,
                "rating" => $product->average
            );
    
            $jsonArray[] = $productData;
        }
    
        return json_encode($jsonArray);
    }
}
?>