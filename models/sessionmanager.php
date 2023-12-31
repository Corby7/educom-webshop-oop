<?php

class SessionManager {

    public function doLoginUser($username, $useremail, $userid) {
        $_SESSION['username'] = $username;
        $_SESSION['useremail'] = $useremail;
        $_SESSION['userid'] = $userid;
        $_SESSION['shoppingcart'] = array();
    }

    public function isUserLoggedIn() {
        return isset($_SESSION['username']) && !empty($_SESSION['username']);
    }
    
    public function getLoggedInUserName() {
        return isset($_SESSION['username']) ? $_SESSION['username'] : '';
    }
    
    public function getLoggedInUserEmail() {
        return isset($_SESSION['useremail']) ? $_SESSION['useremail'] : '';
    }

    public function getLoggedInUserId() {
        return isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
    }

    public function doLogoutUser() {
        session_unset();
        session_destroy(); 
    }
    
    public function getCart() {
        if (isset($_SESSION['shoppingcart'])) {
            return $_SESSION['shoppingcart'];
        } else {
            return array();
        }
    }
    
    public function emptyCart() {
        $_SESSION['shoppingcart'] = array();
    }

    public function addToCart($productId) {
        if (array_key_exists($productId, $_SESSION['shoppingcart'])) {
            $_SESSION['shoppingcart'][$productId] += 1;
        } else {
            $_SESSION['shoppingcart'][$productId] = 1;
        }
    }
    
    public function removeFromCart($productId) {
        if (array_key_exists($productId, $_SESSION['shoppingcart'])) {
            if ($_SESSION['shoppingcart'][$productId] === 1) {
                unset($_SESSION['shoppingcart'][$productId]);
            } else {
            $_SESSION['shoppingcart'][$productId] -= 1;
            }
        }
    }
}

?>