<?php

    define("GENDERS", array("male"=>"Dhr.", "female"=>"Mvr.", "unspecified" => "Anders"));
    define("COMM_PREFS", array("email" => "E-Mail", "phone" => "Telefoon"));

/** Display the title for the contact page. */
function showContactTitle() {
    echo 'ProtoWebsite';
}

/** Display the header for the contact page. */
function showContactHeader() {
    echo 'Contacteer Mij';
}

/** Display the thankyou for filling in the contact form. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showContactThanks($data) {
    // Extract values from the $data array
    extract($data);

    echo '
    <h2>Beste ' . GENDERS[$gender] . ' ' . $fname . ' ' . $lname . ', bedankt voor het invullen van uw gegevens!</h2>
    <h3>Ik zal zo snel mogelijk contact met u opnemen. Ter bevestiging uw informatie:</h3>
    <ul class="submitted_userdata">
        <li><strong>E-mailadres: </strong>' . $email . '</li>
        <li><strong>Telefoonnummer: </strong>' . $phone . '</li>
        <li><strong>Communicatievoorkeur: </strong>' . $preference . '</li>
        <li><strong>Bericht: </strong>' . $message . '</li>
    </ul>';
}

/** Display the form for the contact page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showContactForm($data) {
    require_once('formcreator.php');

    showFormStart(true);
    showFormField('gender', 'Aanhef:', 'select', $data, GENDERS);
    showFormField('fname', 'Voornaam:', 'text', $data);
    showFormField('lname', 'Achternaam:', 'text', $data);
    showFormField('email', 'E-mailadres:', 'email', $data);
    showFormField('phone', 'Telefoonnummer:', 'text', $data);
    showFormField('preference', 'Op welke manier wilt u bereikt worden?', 'radio', $data, COMM_PREFS);
    showFormField('message', 'Waarover wilt u contact opnemen?', 'textarea', $data, [ 'rows' => 5, 'cols' => 33 ]);
    showFormEnd('contact', 'verstuur');

}

?>