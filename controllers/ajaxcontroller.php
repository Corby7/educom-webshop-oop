<?php

class AjaxController {

    public function test($rating) {
        // echo "rating: " .$rating;
    }

    protected function getPostVar($key, $default = "") {
        $value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
        return isset($value) ? $value : $default;
    }

    protected function getUrlVar($key, $default = "") {
        $value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
        return isset($value) ? $value : $default;
    }

    public function processRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // echo 'get';
            $this->handleActions();
        }
    }

    public function handleActions() {
        $function = $this->getUrlVar("function");
        $productId = $this->getUrlVar("id");

        switch($function) {

            case 'getRating':
                echo $productId;
                break;
            default:
                echo 'default';
                break;
        }
    }   

}
?>