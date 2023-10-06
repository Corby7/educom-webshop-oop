<?php

include_once "basic_doc.php";

class ErrorDoc extends BasicDoc {

    protected function showHeader() {
        echo' 
        Error 404';
    }

    protected function showContent() {
        echo '
        <h1>Page Not Found</h1>
        <p>The requested page could not be found. Please check the URL or return to the homepage.</p>';
    }
    
}

?>