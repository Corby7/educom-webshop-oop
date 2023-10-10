<?php
include_once "models/pagemodel.php";

class PageController {
    private $model;

    public function __construct() {
        $this->model = new PageModel(NULL);
    }

    public function handleRequest() {
        $this->getRequest();
        $this->processRequest();
        $this->showResponse();
    }

    //from client
    private function getRequest() {
        $this->model->getRequestedPage();
    }

    //bussiness flow code
    private function processRequest() {
        switch($this->model->page) {

            case 'Login':
                $this->model = new UserModel($this->model);
                $model->validateLogin();
                if ($model->valid) {
                    $this->model->doLoginUser();
                    $this->model->setPage('home');
                }
                break;
            
            //volgt meer code......
        }
    }

    //to client: presentatielaag
    private function showResponse() {
        $this->model->createMenu();

        switch($this->model->page) {

            case 'home':
                require_once("views/home_doc.php");
                $view = new HomeDoc($this->model);
                break;
            
            case 'about':
                require_once("views/about_doc.php");
                $view = new AboutDoc($this->model);
            
 
            //volgt meer code.....
        }
    
        $view->show();
    }

}

?>