<?php
include_once "models/pagemodel.php";
include_once "models/usermodel.php";

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

            case 'login':
                $this->model = new UserModel($this->model);
                $this->model->validateLogin();
                if ($this->model->valid) {
                    $this->model->doLoginUser();
                    $this->model->setPage('home');
                }
                break;
            
            case 'contact':
                $this->model = new UserModel($this->model);
                $this->model->validateContact();
                if ($this->model->valid) {
                    $this->model->setPage('contactthanks');
                }
            //volgt meer code......
        }
    }

    //to client: presentatielaag
    private function showResponse() {
        $this->model->createMenu();
        echo $this->model->page;

        switch($this->model->page) {

            case 'home':
                require_once("views/home_doc.php");
                $view = new HomeDoc($this->model);
                break;
            
            case 'about':
                require_once("views/about_doc.php");
                $view = new AboutDoc($this->model);
                break;
            
            case 'webshop':
                require_once("views/webshop_doc.php");
                $view = new WebshopDoc($this->model);
                break;

            case 'topfive':
                require_once("views/topfive_doc.php");
                $view = new TopFiveDoc($this->model);
                break;

            case 'contact':
                require_once("views/contact_doc.php");
                $view = new ContactDoc($this->model);
                break;
            
            case 'register':
                require_once("views/register_doc.php");
                $view = new RegisterDoc($this->model);
                break;

            case 'login':
                require_once("views/login_doc.php");
                $view = new LoginDoc($this->model);
                break;
            //volgt meer code.....
        }
    
        $view->show();
    }

}

?>