<?php

class ShopModel extends PageModel {

    public function __construct($pageModel, $shopCrud) {
        PARENT::__construct($pageModel);
        $this->shopCrud = $shopCrud;
    }

    private $shopCrud;
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
        return $this->shopCrud->getAllProducts();
    }

    public function getTopFiveData() {
        return $this->shopCrud->getTopFiveProducts();
    }

    public function getProductPageData($productid) {
        return $this->shopCrud->getProduct($productid);
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
            $cart = $this->sessionManager->getCart();
            $userId = $this->sessionManager->getLoggedInUserId();
            $this->shopCrud->createOrder($userId, $cart);
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
            // require_once("mysqlconnect.php");
            $cartProducts = $this->shopCrud->getProductsByIds($productids);
            var_dump($cartProducts);

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

