<?php
include_once "models/usermodel.php";
include_once "models/shopmodel.php";


class PageController {

    private $modelFactory;
    private $model;

    public function __construct($modelFactory) {
        $this->modelFactory = $modelFactory;
        $this->model = $this->modelFactory->createModel('page');
    }

    private function logError($message) {
        echo "LOG TO FILE: " . $message;
    }

    public function handleRequest() {
        $actionValue = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : null);
        if ($actionValue === 'ajax') {
            require_once('ajaxcontroller.php');
            $ajaxController = new AjaxController($this->modelFactory);
            $ajaxController->handleRequest();
        } else {
        $this->getRequest();
        $this->processRequest();
        $this->showResponse();
        }
    }

    //from client
    private function getRequest() {
        $this->model->getRequestedPage();
    }

    //bussiness flow code
    private function processRequest() {
        switch($this->model->page) {

            case 'contact':
                $this->model = $this->modelFactory->createModel('user');
                if ($this->model->isPost) {
                    $this->model->validateContact();
                    if ($this->model->valid) {
                        $this->model->setPage('contactthanks');
                    }
                }
                break;

            case 'webshop':
                $this->model = $this->modelFactory->createModel('shop');
                $this->model->products = $this->model->getWebshopData();
                break;

            case 'topfive':
                $this->model = $this->modelFactory->createModel('shop');
                $this->model->products = $this->model->getTopFiveData();
                break;

            case 'productpage':
                $this->model = $this->modelFactory->createModel('shop');
                $this->model->product = $this->model->getProductPageData();
                break;

            case 'shoppingcart':
                $this->model = $this->modelFactory->createModel('shop');
                if ($this->model->isPost) {
                    if ($this->model->handleCartActions()) {
                        $this->model->setPage('ordersucces');
                    }
                } 
                $this->model->getCartLines();
                break;

            case 'register':
                $this->model = $this->modelFactory->createModel('user');
                if ($this->model->isPost) {
                    $this->model->validateRegister();
                    if ($this->model->valid) {
                        if ($this->model->storeUser()) {
                            $this->model->setPage('login');
                        };
                    }
                }
                break;
            
            case 'login':
                $this->model = $this->modelFactory->createModel('user');
                if ($this->model->isPost) {
                    $this->model->validateLogin();
                    if ($this->model->valid) {
                        $this->model->doLoginUser();
                        $this->model->setPage('home');
                    }
                }
                break;

            case 'accountsettings':
                $this->model = $this->modelFactory->createModel('user');
                $this->model->validateAccountSettings();
                if ($this->model->valid) {
                    $this->model->updatePasswordbyEmail();
                }
                break;
            
            case 'logout':
                $this->model = $this->modelFactory->createModel('user');
                $this->model->doLogoutUser();
                $this->model->setPage('home');
                break;

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
                break;

            case 'contact':
                require_once("views/contact_doc.php");
                $view = new ContactDoc($this->model);
                break;
            
            case 'contactthanks':
                require_once("views/contactthanks_doc.php");
                $view = new ContactThanksDoc($this->model);
                break;
            
            case 'webshop':
                require_once("views/webshop_doc.php");
                $view = new WebshopDoc($this->model);
                break;

            case 'topfive':
                require_once("views/topfive_doc.php");
                $view = new TopFiveDoc($this->model);
                break;

            case 'productpage':
                require_once("views/productpage_doc.php");
                $view = new ProductPageDoc($this->model);
                break;
            
            case 'shoppingcart':
                require_once("views/shoppingcart_doc.php");
                $view = new ShoppingCartDoc($this->model);
                break;

            case 'ordersucces':
                require_once("views/ordersucces_doc.php");
                $view = new OrderSuccesDoc($this->model);
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

            default:
                require_once("views/error_doc.php");
                $view = new ErrorDoc($this->model);
                break;
            //volgt meer code.....
        }
    
        $view->show();
    }

}

?>