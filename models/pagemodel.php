<?php
include_once "sessionmanager.php";
include_once "menuitem.php";

class PageModel {

    public $page;
    public $isPost = false;
    public $menu;
    public $genericErr = "";
    protected $sessionManager;

    public function __construct($copy) {
        if (empty($copy)) {
            // ==> First instance of PageModel
            $this->sessionManager = new SessionManager();
        } else {
            // ==> Called from the constructer of an extended class..
            $this->page = $copy->page;
            $this->isPost = $copy->isPost;
            $this->menu = $copy->menu;
            $this->genericErr = $copy->genericErr;
            $this->sessionManager = $copy->sessionManager;
        }
    }

    public function logError($message) {
        echo "LOG TO FILE: " . $message;
    }

    public function getRequestedPage() {
        $this->isPost = ($_SERVER['REQUEST_METHOD'] == 'POST');

        if ($this->isPost) {
            $this->setPage($this->getPostVar('page', 'home'));
        } else {
            $this->setPage($this->getUrlVar('page', 'home'));
        }
    }

    public function setPage($newPage) {
        $this->page = $newPage;
    }

    protected function getPostVar($key, $default = "") {
        $value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
        return isset($value) ? $value : $default;
    }

    protected function getUrlVar($key, $default = "") {
        $value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
        return isset($value) ? $value : $default;
    }

    public function createMenu() {
        $this->menu['home'] = new MenuItem('home', 'HOME');
        $this->menu['about'] = new MenuItem('about', 'ABOUT');
        $this->menu['webshop'] = new MenuItem('webshop', 'WEBSHOP');
        $this->menu['topfive'] = new MenuItem('topfive', 'TOP-5');
        $this->menu['contact'] = new MenuItem('contact', 'CONTACT');
        if (!$this->sessionManager->isUserLoggedIn()) {
            $this->menu['register'] = new MenuItem('register', 'REGISTER', 'me-auto');
            $this->menu['login'] = new MenuItem('login', 'LOGIN');
        }
        if ($this->sessionManager->isUserLoggedIn()) {
            $this->menu['accountsettings'] = new MenuItem('', '', 'me-auto', 'bi bi-person-circle');
            $this->menu['accountsettings']->addSubItem('accountsettings', 'Wachtwoord wijzigen',);
            $this->menu['accountsettings']->addSubItem('logout', 'Logout: ' . $this->sessionManager->getLoggedInUserName());
            
            $this->menu['shoppingcart'] = new MenuItem('shoppingcart', 'SHOPPING CART', '', 'bi bi-bag-check');
        }
    }
}

?>