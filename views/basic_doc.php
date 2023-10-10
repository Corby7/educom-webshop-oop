<?php
include_once "html_doc.php";
//require('../sessionmanager.php');

class BasicDoc extends HtmlDoc {

    protected $model;

    public function __construct($myData) {
        $this->model = $myData;
        //var_dump($this->model->menu);
    }

    private function showTitle() {
        echo
        '<title>' . $this->model->page . '</title>';
    }

    private function showCSSLink() {
        echo
        '<link rel="stylesheet" href="CSS/style.css">';
    }

    protected function showHeader() {}

    private function showMenu() {
        echo
        '<nav> 
            <ul class="lowernav">'; 
            foreach ($this->model->menu as $key => $menuItem) {
                $this->showMenuItem($menuItem->getLink(), $menuItem->getText());
            }
            echo '
            </ul>  
        </nav>';
    }

    private function showMenuItem($link, $text) {
        echo '<li><a href="index.php?page=' . $link . '">' . $text . '</a></li>';
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