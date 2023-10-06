<?php

/** Display the title for the register page. */
function showRegisterTitle() {
    echo 'Register';
}

/** Display the header for the register page. */
function showRegisterHeader() {
    echo 'Registreer Nu!';
}

/** Display the form for the register page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showRegisterForm($data) {
    require_once('formcreator.php');

    showFormStart(true);
    showFormField('fname', 'Voornaam:', 'text', $data);
    showFormField('lname', 'Achternaam:', 'text', $data);
    showFormField('email', 'E-mailadres:', 'email', $data);
    showFormField('pass', 'Wachtwoord:', 'password', $data);
    showFormField('repeatpass', 'Herhaal wachtwoord:', 'password', $data);
    showFormEnd('register', 'verstuur');

}

?>
