<?php
include_once "html_doc.php";
//require('../sessionmanager.php');

class BasicDoc extends HtmlDoc {

    protected $model;

    public function __construct($myData) {
        $this->model = $myData;
    }

    private function showTitle() {
        echo '
        <title>' . $this->model->page . '</title>';
    }

    private function showCSSLink() {
        echo '
        <link rel="stylesheet" href="CSS/style.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">';
    }

    protected function showHeader() {}

    private function GetIconMarkup($name, $class) {
        $svgContent = file_get_contents("Images/$name.svg");
        $svgContent = str_replace('<svg', '<svg class=' . $class . '', $svgContent);
        return $svgContent;
    }

    private function showMenu() {
        echo '
        <nav class="navbar navbar-expand">
            <a href="#" class="navbar-brand mx-2">' . $this->GetIconMarkup('logo', 'brandicon-top') . '</a>
          
            <ul class="navbar-nav container-fluid h6 d-flex justify-content-center">'; 
            foreach ($this->model->menu as $menuItem) {
                $this->showMenuItem($menuItem);
            }
            echo '
            </ul>  
        </nav>';
    }
    
    private function showMenuItem($menuItem) {
        $link = $menuItem->getLink();
        $text = $menuItem->getText();
        $styling = $menuItem->getStyling();

        //dit is opzetje voor dropdown
        // if (count($menuItem->getSubitems()) > 0)
        // {

        // } else 

        if ($link === 'shoppingcart') {
            echo ' 
            <a class="nav-link link-body-emphasis active text-white ms-auto" href="index.php?page=shoppingcart" role="button" id="shoppingcart">
                <i class="bi bi-bag-check"></i>
            </a>';

        //dit verder uitwerken
        } else {
            echo '<li class="nav-item"><a class="' . $styling . '" href="index.php?page=' . $link . '">' . $text . '</a></li>';
            if ($menuItem->getLogo()) {}
             . $text . '</a></li>';
        };

    }

    protected function showGenericErr() {
        if (isset($this->model->genericErr) && !empty($this->model->genericErr)) {
            echo '<div class="error">' . $this->model->genericErr . '</div>';
        }
    }

    protected function showContent() {}

    private function showFooter() {
        echo'
        <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 mx-2 d-flex align-items-center">
                <a class="text-body-secondary" href="#" class="navbar-brand mx-2">' . $this->GetIconMarkup('logo', 'brandicon-bot') . '</a>
                <span class="mb-3 mb-md-0 text-body-secondary fst-italic">&copy; 2023 Jules Corbijn Bulsink</span>
            </div>
    
            <ul class="nav col-md-4 mx-2 justify-content-end list-unstyled d-flex">
                <li class="ms-3 mx-2"><a class="text-body-secondary" href="https://linkedin.com/in/jules-corbijn-bulsink"><i class="bi bi-linkedin"></i></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="https://github.com/Corby7"><i class="bi bi-github"></i></a></li>
            </ul>
        </footer>';
    }

    protected function showHeadContent() {
        $this->showTitle();
        $this->showCSSlink();
    }

    protected function showBodyContent() {
        $this->showMenu();
        echo '
        <div class="container body-content d-flex flex-column flex-grow-1 px-5">
            <header class="py-4">
                <div class="header-container h2">';
                    $this->showHeader();
                echo '
                </div>
            </header>';
            $this->showGenericErr();
            $this->showContent();
        echo'
        </div>';
        $this->showFooter();
    }

}

?>