<?php

session_start(); 

require('sessionmanager.php');

function logError($message) {
    echo "LOG TO FILE: " . $message;
}

/** MAIN APP */
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);

/**
 * Get the requested page based on the request method.
 *
 * @param string $page The default page to return if the request method is not POST.
 * @return string The requested page.
 */
function getRequestedPage() {
    $requested_type = $_SERVER['REQUEST_METHOD'];
    if ($requested_type == 'POST') {
        $requested_page = getPostVar('page', 'home');
    } else {
        $requested_page = getUrlVar('page', 'home');
    }

    return $requested_page;
}

/**
 * Get a POST variable with optional default value.
 *
 * @param string $key The key to search for in the POST data.
 * @param string $default (optional) The default value to return if the key is not found.
 * @return string The value of the POST variable or the default if not found.
 */
function getPostVar($key, $default = '') {
    $value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
    return isset($value) ? $value : $default;
}

/**
 * Get a URL variable with optional default value.
 *
 * @param string $key The key to search for in the URL.
 * @param string $default (optional) The default value to return if the key is not found.
 * @return string The value of the URL variable or the default if not found.
 */
function getUrlVar($key, $default = '') {
    $value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
    return isset($value) ? $value : $default;
}


/**
 * Process the request and perform actions based on the page and request method.
 *
 * This function handles both GET and POST requests for different pages of the web application.
 * It performs the following steps:
 *
 * 1. Initialize form data for the specified page using `initializeFormData`.
 * 2. If the request method is POST:
 *    - For the "contact" page, validate the contact form data and update the page to "thanks" if the data is valid.
 *    - For the "register" page, validate the registration form data. If valid, save the user and update the page to "login."
 *    - For the "login" page, validate the login form data, authenticate the user, and set the user's session if successful.
 *      It also handles errors related to unknown users or wrong passwords.
 * 3. If the request method is GET:
 *    - For the "logout" page, log the user out and update the page to "home."
 *
 * Finally, it sets the page in the `$data` array and returns it.
 * 
 * @param string $page The current page.
 * @return array An array containing input data for the response page.
 */
function processRequest($page) {
    require_once('validations.php');
    $data = initializeFormData($page);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        switch($page) {
            case 'contact':
                $data = validateContactForm($data);
                if($data['valid']) {
                    $page = "thanks";
                }
                break;

            case 'register':
                $data = validateRegisterForm($data);
                if ($data['valid']) {
                    extract($data);

                    try {
                    storeUser($name, $email, $pass);
                    $page = "login";
                    } catch (Exception $e) {
                        logError("Store user failed: " . $e->getMessage());
                        $passcheckErr = "Sorry technisch probleem, gegevens opslaan niet mogelijk";
                    }
                }
                break;

            case 'accountsettings':
                $data = validateSettingsForm($data);
                if ($data['valid']) {
                    extract($data);

                    try {
                        $data = updatePasswordByEmail($email, $newpass, $data);
                    } catch (Exception $e) {
                        logError("Update password failed: " . $e->getMessage());
                        $passcheckErr= "Wachtwoord bijwerken niet mogelijk";
                    }
                }
                break;

            case 'login':
                $data = validateLoginForm($data);
                if ($data['valid']) {
                    extract($data);

                    loginUser($username, $useremail);
                    $page = "home";
                }
                break;

            case 'shoppingcart':
                require_once('userservice.php');
                handleActions();
                $data['products'] = populateCart();
                break;
            
            case 'checkout':
                require_once('userservice.php');
                if (makeOrder()) {
                    $_SESSION['shoppingcart'] = array();
                    $page = 'ordersucces';
                }
                break;
        }

        $data['page'] = $page;
        return $data;

    } else { //if GET request

        switch($page) {
            case 'logout':
                logoutUser();
                $page = "home";
                break;
                
            case 'webshop':
                try {
                    require_once('userservice.php');
                    $data['products'] = getAllProducts();
                } catch (Exception $e) {
                    logError("Get all products failed: " . $e->getMessage());
                }
                break;
            
            case 'topfive':
                try {
                    require_once('userservice.php');
                    $data['products'] = getTopFiveProducts();
                } catch (Exception $e) {
                    logError("Get top five products failed: " . $e->getMessage());
                }
                break;

            case 'productpage':
                $productid = getUrlVar("productid");
                try {
                    require_once('userservice.php');
                    $data['product'] = getProduct($productid);
                    $page = "productpage";
                } catch (Exception $e) {
                    logError("Get product by id failed: " . $e->getMessage());
                }
                break;

            case 'shoppingcart':
                require_once('userservice.php');
                $data['products'] = populateCart();
                break;
        }

        $data['page'] = $page;
        //var_dump($data);
        return $data;
    }
}

function handleActions() {
    $action = getPostVar("action");

    switch($action) {
        case "addtocart":
            $productid = getPostVar("id");
            addToCart($productid);
            break;
        case "removefromcart":
            $productid = getPostVar("id");
            removeFromCart($productid);
            break;
    }
}   

/**
 * Display the response page based on the input data.
 *
 * @param array $data An array containing input data for the response page.
 */
function showResponsePage($data) {
    $view = NULL;
    echo "hoi";

    switch ($data['page']) {
        case 'home':
            require_once("views/home_doc.php");
            $view = new HomeDoc($data);
            break;
    
        case 'about':
            require_once("views/about_doc.php");
            $view = new AboutDoc($data);
            break;
    
        case 'webshop':
            require_once("views/webshop_doc.php");
            $view = new WebshopDoc($data);
            break;
    
        case 'topfive':
            require_once("views/topfive_doc.php");
            $view = new TopFiveDoc($data);
            break;
    
        case 'register':
            require_once("views/register_doc.php");
            $view = new RegisterDoc($data);
            break;
    
        case 'productpage':
            require_once("views/productpage_doc.php");
            $view = new ProductPageDoc($data);
            break;

        case 'contact':
            require_once("views/contact_doc.php");
            $view = new ContactDoc($data);
            break;
    
        case 'login':
            require_once("views/login_doc.php");
            $view = new LoginDoc($data);
            break;
    
        case 'accountsettings':
            require_once("views/accountsettings_doc.php");
            $view = new AccountSettingsDoc($data);
            break;
        
        default:
            require_once("views/error_doc.php");
            $view = new ErrorDoc($data);
            break;
    }
    $view->show();
}
