<?php

//extends pagemodel for sessionmanager and geturlvar/postvar functions?
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
                $userId = $this->model->sessionManager->getLoggedInUserId();
                
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