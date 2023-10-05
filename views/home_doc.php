<?php

include_once "basic_doc.php";

class HomeDoc extends BasicDoc {

    protected function showHeader() {
        echo 
        'Welkom op Mijn Website';
    }

    protected function showContent() {
        echo '
        <p>Welkom op mijn ProtoWebsite! Zoals de naam hopelijk al verhuld is dit een prototype voor mijn eerste website voor Educom. <br> Veel browseplezier!</p>';
    }

}

?>