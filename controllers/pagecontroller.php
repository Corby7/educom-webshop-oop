<?php
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

            case 'contact':
                $this->model = new UserModel($this->model);
                $this->model->validateContact();
                if ($this->model->valid) {
                    $this->model->setPage('contactthanks');
                }
                break;
            
            case 'register':
                $this->model = new UserModel($this->model);
                $this->model->validateRegister();
                if ($this->model->valid) {
                    try {
                        storeUser($this->model->name, $this->model->email, $this->model->pass);
                        $this->model->setPage('login');
                    } catch (Exception $e) {
                        logError("Store user failed: " . $e->getMessage());
                        $genericErr = "Sorry technisch probleem, gegevens opslaan niet mogelijk";
                    }
                }
                break;
            
            case 'login':
                $this->model = new UserModel($this->model);
                $this->model->validateLogin();
                if ($this->model->valid) {
                    $this->model->doLoginUser();
                    $this->model->setPage('home');
                }
                break;

            case 'accountsettings':
                $this->model = new UserModel($this->model);
                $this->model->validateAccountSettings();
                if ($this->model->valid) {
                    try {
                        $this->model->updatePasswordbyEmail();
                    } catch (Exception $e) {
                        logError("Update password failed: " . $e->getMessage());
                        $genericErr = "Wachtwoord bijwerken niet mogelijk";
                    }
                }
                break;
            
            case 'logout':
                $this->model = new UserModel($this->model);
                $this->model->doLogoutUser();
                $this->model->setPage('home');
                break;

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

            case 'contactthanks':
                require_once("views/contactthanks_doc.php");
                $view = new ContactThanksDoc($this->model);
                break;
            
            case 'register':
                require_once("views/register_doc.php");
                $view = new RegisterDoc($this->model);
                break;

            case 'login':
                require_once("views/login_doc.php");
                $view = new LoginDoc($this->model);
                break;
            
            case 'accountsettings':
                require_once("views/accountsettings_doc.php");
                $view = new AccountSettingsDoc($this->model);
                break;

            //volgt meer code.....
        }
    
        $view->show();
    }

}

?>