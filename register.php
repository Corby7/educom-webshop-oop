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
    //extract values from the $userdata array
    require('formcreator.php');
    $extraErrors = ['passcheckErr', 'emailknownErr', 'emailunknownErr', 'wrongpassErr'];
    $resultArray = array_intersect_key($data, array_flip($extraErrors));
    //var_dump($extraErrors);
    if (!empty($resultArray)) {
        var_dump($resultArray);
    }

    if (!empty(array_filter($resultArray, function ($value) {
        return !empty($value) || $value === 0;
    }))) {
        var_dump($resultArray);
    }
    //var_dump($data);

    showFormStart(true);
    showFormField('fname', 'Voornaam:', 'text', $data);
    showFormField('lname', 'Achternaam:', 'text', $data);
    showFormField('email', 'E-mailadres:', 'email', $data, NULL, false, $extraErrors);
    showFormField('pass', 'Wachtwoord:', 'password', $data);
    showFormField('repeatpass', 'Herhaal wachtwoord:', 'password', $data, NULL, false, $extraErrors);
    showFormEnd('register', 'verstuur');

}

?>
