<?php

/** Display the title for the settings page. */
function showSettingsTitle() {
    echo 'settings';
}

/** Display the header for the settings page. */
function showSettingsHeader() {
    echo 'Wachtwoord wijzigen';
}

/** Display the form for the settings page. 
 *  
 * @param array $data An array containing input data for the response page.
*/
function showSettingsForm($data) {
    require_once('formcreator.php');

    showFormStart(true);
    showFormField('pass', 'Oud wachtwoord:', 'password', $data);
    showFormField('newpass', 'Nieuw wachtwoord:', 'password', $data);
    showFormField('repeatpass', 'Herhaal nieuw wachtwoord:', 'password', $data);
    if (isset($data['passwordUpdated'])) {
        echo '<span class="success">' . $data['passwordUpdated'] . '</span>';
    }
    showFormEnd('settings', 'Wachtwoord wijzigen');
}

?>
