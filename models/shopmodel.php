<?php

class ShopModel extends PageModel {

    public function __construct($pageModel) {
        PARENT::__construct($pageModel);
    }

    public $products = array();
    public $product = array();
    public $cartLines = array();
    public $cartTotal = 0;

    public function isUserLoggedIn() {
        return $this->sessionManager->isUserLoggedIn();
    }

    public function getProductIdFromUrl() {
        return $this->getUrlVar("productid");
    }

    public function getWebshopData() {
        require_once("mysqlconnect.php");
        return getAllProducts();
    }

    public function getTopFiveData() {
        require_once("mysqlconnect.php");
        return getTopFiveProducts();
    }

    public function getProductPageData($productid) {
        require_once("mysqlconnect.php");
        return getProduct($productid);
    }

    public function handleCartActions() {
        $action = $this->getPostVar("action");

        switch($action) {
            
            case 'addtocart':
                $productid = $this->getPostVar("id");
                $this->sessionManager->addToCart($productid);
                break;

            case 'removefromcart':
                $productid = $this->getPostVar("id");
                $this->sessionManager->removeFromCart($productid);
                break;
            
            case 'checkout':
                if ($this->makeOrder()) {
                    $_SESSION['shoppingcart'] = array();
                    return true;
                }
                break;
        }
    }

    
    public function makeOrder() {
        try {
            $cart = $_SESSION['shoppingcart'];
            $email = $_SESSION['useremail'];
            require_once("mysqlconnect.php");
            //maybe just use private user id i saved somewhere?
            $useridArray = getUserId($email);
            $useridString = reset($useridArray);
            createOrder($useridString, $cart);
            return true;
        } catch (Exception $e) {
            logError("Checkout failed: " . $e->getMessage());
            return false;
        }
    }


    public function getCartLines() {
        try {
            $cart = $this->sessionManager->getCart();
            
            if (empty($cart)) {
                return;
            }
            $productids = array_keys($cart);
            require_once("mysqlconnect.php");
            $cartProducts = getProductsByIds($productids);
            foreach($cart as $productid => $quantity) {
                $product = $cartProducts[$productid];  
                extract($product);                       
                $subtotal = $price * $quantity; 
                $this->cartTotal += $subtotal;
                $this->cartLines[] = compact('id', 'filenameimage', 'name', 'price', 'quantity', 'subtotal');
            } 
        } catch (Exception $e) {
            logError("Getting cart products failed: " . $e->getMessage()); 
            return array('genericErr' => 'door een technische storing kunnen wij uw winkelwagen niet laten zien');
        }
    }

}

?>