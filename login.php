<?php

/** Display the title for the login page. */
function showLoginTitle() {
    echo 'Login';
}

/** Display the header for the login page. */
function showLoginHeader() {
    echo 'Login';
}

/** Display the form for the login page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showLoginForm($data) {
    require_once('formcreator.php');
    
    showFormStart(true);
    showFormField('email', 'E-mailadres:', 'email', $data);
    showFormField('pass', 'Wachtwoord:', 'password', $data);
    showFormEnd('login', 'Inloggen');
}

?>