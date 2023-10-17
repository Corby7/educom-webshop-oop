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

                try {
                    require_once("mysqlconnect.php");
                    $this->model->products = $this->model->getWebshopData();
                } catch (Exception $e) {
                    logError("Get all products failed: " . $e->getMessage());
                }
                break;

            case 'topfive':
                $this->model = $this->modelFactory->createModel('shop');

                try {
                    require_once("mysqlconnect.php");
                    $this->model->products = $this->model->getTopFiveData();
                } catch (Exception $e) {
                    logError("Get top five products failed: " . $e->getMessage());
                }
                break;

            case 'productpage':
                $this->model = $this->modelFactory->createModel('shop');
                $productid = $this->model->getProductIdFromUrl();

                try {
                    require_once("mysqlconnect.php");
                    $this->model->product = $this->model->getProductPageData($productid);
                } catch (Exception $e) {
                    logError("Get product by id failed: " . $e->getMessage());
                }
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
                        try {
                            $this->model->storeUser($this->model->name, $this->model->email, $this->model->pass);
                            $this->model->setPage('login');
                        } catch (Exception $e) {
                            logError("Store user failed: " . $e->getMessage());
                            $this->model->genericErr = "Sorry technisch probleem, gegevens opslaan niet mogelijk";
                        }
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
                    try {
                        $this->model->updatePasswordbyEmail();
                    } catch (Exception $e) {
                        logError("Update password failed: " . $e->getMessage());
                        $this->model->genericErr = "Wachtwoord bijwerken niet mogelijk";
                    }
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