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

    public function getWebshopData() {
        try {
            return $this->shopCrud->getAllProducts();
        } catch (Exception $e) { 
            logError("Get all products failed: " . $e->getMessage()); 
            $this->genericErr = "Sorry technisch probleem, gegevens ophalen niet mogelijk"; 
        } 
    }

    public function getTopFiveData() {
        try {
            return $this->shopCrud->getTopFiveProducts();
        } catch (Exception $e) { 
            logError("Get all products failed: " . $e->getMessage()); 
            $this->genericErr = "Sorry technisch probleem, gegevens ophalen niet mogelijk"; 
        }
    }

    public function getProductPageData() {
        try {
            $productid = $this->getUrlVar("productid");
            return $this->shopCrud->getProduct($productid);
        } catch (Exception $e) { 
            logError("Get all products failed: " . $e->getMessage()); 
            $this->genericErr = "Sorry technisch probleem, gegevens ophalen niet mogelijk"; 
        }
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
            $this->genericErr = "Sorry technisch probleem, order plaatsen niet mogelijk"; 
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
            $cartProducts = $this->shopCrud->getProductsByIds($productids);

            foreach($cart as $productid => $quantity) {
                $product = $cartProducts[$productid];    
                $subtotal = $product->price * $quantity; 
                $this->cartTotal += $subtotal;

                $this->cartLines[] = [
                    'id' => $product->id,
                    'filenameimage' => $product->filenameimage,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
            } 
        } catch (Exception $e) {
            logError("Getting cart products failed: " . $e->getMessage()); 
            $this->genericErr = "Sorry, door een technische storing kunnen wij uw winkelwagen niet weergeven"; 
        }
    }

}

?>

