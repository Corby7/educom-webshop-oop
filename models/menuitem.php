<?php

class MenuItem {
    private $link;
    private $text;
    private $styling;
    private $logo;
    private $subItems = array();

    public function __construct($link, $text, $styling = 'nav-link link-body-emphasis px-4 active text-white', $logo = "") {
        $this->link = $link;
        $this->text = $text;
        $this->styling = $styling;
    }

    public function getLink() {
        return $this->link;
    }
    
    public function getText() {
        return $this->text;
    }

    public function getStyling() {
        return $this->styling;
    }

    public function addLogo($biLogo) {
        $this-> logo = $biLogo;
    }
}

?>