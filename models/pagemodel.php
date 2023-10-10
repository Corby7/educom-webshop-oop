<?php
include_once "sessionmanager.php";
include_once "menuitem.php";

class PageModel {

    public $page;
    protected $isPost = false;
    public $menu;
    public $errors = array();
    public $genericErr = "";
    protected $sessionManager;
    //....

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

    public function getRequestedPage() {
        $this->isPost = ($_SERVER['REQUEST_METHOD'] == 'POST');

        if ($this->isPost) {
            $this->setPage($this->getPostVar('page', 'home'));
        } else {
            $this->setPage($this->getUrlVar('page', 'home'));
        }
    }

    protected function setPage($newPage) {
        echo "page=$newPage";
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
        $this->menu['topfive'] = new MenuItem('topfive', 'TOPFIVE');
        $this->menu['contact'] = new MenuItem('contact', 'CONTACT');
        $this->menu['register'] = new MenuItem('register', 'REGISTER');
        $this->menu['login'] = new MenuItem('login', 'LOGIN');
        if ($this->sessionManager->isUserLoggedIn()) {
            $this->menu['accountsettings'] = new MenuItem('accountsettings', 'ACCOUNT SETTINGS');
            $this->menu['logout'] = new MenuItem('logout', 'LOGOUT', 
                $this->sessionManager->getLoggedInUser()['name']);
        }
        //var_dump($this->menu);
    }
}

?>