<?php

class HtmlDoc {

    private function showHtmlStart() {
        echo '
        <!DOCTYPE html>
        <html lang="en">';
    }

    private function showHeadStart() {
        echo '
        <head>';
    }

    private function showHeadContent() {
        echo '
        <title>hoi!</title>';
    }

    private function showHeadEnd() {
        echo '
        </head>';
    }

    private function showBodyStart() {
        echo '
        <body>';
    }

    private function showBodyContent() {
        echo '
        <p>Hello World!</p>';
    }

    private function showBodyEnd() {
        echo '
        </body>';
    }

    private function showHtmlEnd() {
        echo '
        </html>';
    }

    public function show() {
        $this->showHtmlStart();
        $this->showHeadStart();
        $this->showHeadContent();
        $this->showHeadEnd();
        $this->showBodyStart();
        $this->showBodyContent();
        $this->showBodyEnd();
        $this->showHtmlEnd();
    }

}

?>