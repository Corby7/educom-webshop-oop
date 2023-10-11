<?php

class ShopModel extends PageModel {

    public function __construct($pageModel) {
        PARENT::__construct($pageModel);
    }

    public $products = array();
    public $product = array();
    public $cartLines = array();
    public $cartTotal = array();

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
        $action = $this->getPostVar("id");

        switch($action) {
            
            case 'addtocart':
                $productid = getPostVar("id");
                $this->sessionManager->addToCart($productid);
                break;

            case 'removefromcart':
                $productid = getPostVar("id");
                $this->sessionManager->removeFromCart($productid);
                break;
            
            //deze nog aanpassen
            // case 'checkout':
            //     require_once('userservice.php');
            //     if (makeOrder()) {
            //         $_SESSION['shoppingcart'] = array();
            //         return true;
            //     }
            //     break;
        }
    }


    public function populateCart() {
        try {
            $cartLines = array();
            $total = 0; 
    
            $cart = $this->sessionManager->getCart();
            if (empty($cart)) {
                return compact('cartLines', 'total');  
            }
            $productids = array_keys($cart);
            $cartProducts = getProductsByIds($productids);
            foreach($cart as $productid => $quantity) {
               $product = $cartProducts[$productid];  
               extract($product);                       
               $subtotal = $price * $quantity; 
               $total += $subtotal;
               $cartLines[] = compact('id', 'filenameimage', 'name', 'price', 'quantity', 'subtotal');
            } 
            return compact('cartLines', 'total');  
        } catch (Exception $e) {
            logError("Getting cart products failed: " . $e->getMessage()); 
            return array('genericErr' => 'door een technische storing kunnen wij uw winkelwagen niet laten zien');
        }
    }
}

?>