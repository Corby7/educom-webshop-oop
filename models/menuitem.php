<?php

class MenuItem {
    private $link;
    private $text;

    public function __construct($link, $text) {
        $this->link = $link;
        $this->text = $text;
    }

    public function getLink() {
        return $this->link;
      }
    
    public function getText() {
    return $this->text;
    }
}

?>