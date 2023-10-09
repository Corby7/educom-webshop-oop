<?php

include_once "basic_doc.php";

class OrderSuccesDoc extends BasicDoc {

    protected function showHeader() {
        echo 
        'Order succesvol!';
    }

    protected function showContent() {
        echo '<h1>Bedankt voor uw bestelling! Check uw mail voor de orderinfo.</h1>';
    }

}

?>