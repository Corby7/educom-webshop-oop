<?php
include_once "html_doc.php";
require('../sessionmanager.php');

class BasicDoc extends HtmlDoc {

    protected $data;

    public function __construct($myData) {
        $this->data = $myData;
    }

    private function showTitle() {
        echo
        '<title>' . $this->data['page'] . '</title>';
    }

    private function showCSSLink() {
        echo
        '<link rel="stylesheet" href="CSS/style.css">';
    }

    protected function showHeader() {}

    private function showMenu() {
        function showMenuItem($link, $text) {
            echo '<li><a href="index.php?page=' . $link . '">' . $text . '</a></li>';
        }

        echo
        '<nav>';  
        if(isUserLoggedIn()) {
            echo '<ul class="uppernav">';
            showMenuItem("settings", "Account Settings");
            showMenuItem("logout", "Logout: " . getLoggedInUserName());
            showMenuItem("shoppingcart", "Shopping Cart");
            echo '</ul>';
        }
        echo '<ul class="lowernav">';
        showMenuItem("home", "HOME"); 
        showMenuItem("about", "ABOUT");
        showMenuItem("webshop", "WEBSHOP");
        showMenuItem("topfive", "TOP 5");
        showMenuItem("contact", "CONTACT");
        if(!isUserLoggedIn()) { 
            showMenuItem("register", "REGISTER"); 
            showMenuItem("login", "LOGIN");
        } 
        echo '
            </ul>  
        </nav>';
    }

    protected function showContent() {}

    private function showFooter() {
        echo
        '<footer>
            <p>&copy; 2023 Jules Corbijn Bulsink</p>
        </footer>';
    }

    protected function showHeadContent() {
        $this->showTitle();
        $this->showCSSlink();
    }

    protected function showBodyContent() {
        $this->showHeader();
        $this->showMenu();
        $this->showContent();
        $this->showFooter();
    }

}

?>