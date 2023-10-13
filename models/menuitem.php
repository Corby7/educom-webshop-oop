<?php

class MenuItem {
    private $link;
    private $text;
    private $styling;
    private $icon;
    private $subItems = array();

    public function __construct($link, $text, $styling = "", $icon = "") {
        $this->link = $link;
        $this->text = $text;
        $this->styling = $styling;
        $this->icon = $icon;
    }

    public function addSubItem($link, $text, $styling = "dropdown-item av-link link-body-emphasis px-3 active text-black bg-white fw-bold", $icon = "") {
        $this->subItems[] = new MenuItem($link, $text, $styling, $icon);
    }

    public function getSubItems() {
        return $this->subItems;
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

    public function getIcon() {
        return $this->icon;
    }
}

?>