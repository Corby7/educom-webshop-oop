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

    protected function showHeadContent() {}

    private function showHeadEnd() {
        echo '
        </head>';
    }

    private function showBodyStart() {
        echo '
        <body>
            <div class="wrapper body-container d-flex flex-column justify-content-between min-vh-100 ">';
    }

    protected function showBodyContent() {}

    private function showBodyEnd() {
        echo '
                </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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