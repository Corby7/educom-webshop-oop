<?php

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
    <h2>Beste ' . getSalutation($gender) . ' ' . $fname . ' ' . $lname . ', bedankt voor het invullen van uw gegevens!</h2>
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
    define("GENDERS", array("male"=>"Dhr.", "female"=>"Mvr.", "unspecified" => "Anders"));
    define("COMM_PREFS", array("email" => "E-Mail", "phone" => "Telefoon"));
 

    function showFormStart($hasRequiredFields) {
        echo'
        <form method="post" action="index.php">';
            if ($hasRequiredFields) {
                echo'
                <p><span class="error"><strong>* Vereist veld</strong></span></p>';
            }
            echo'
            <ul class="flex-outer">';
    }

    function showFormField($fieldName, $label, $type, $data, $options = NULL, $optional = false) {

        echo '
        <li>';

     
        switch($type) {
            case 'text':
            case 'email':
                echo '
                <label for="' . $fieldName . '">' . $label . '</label>
                <input type="' . $type . '" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $data[$fieldName] . '">';
                break;

            case 'select':
                echo '
                <label for="' . $fieldName . '">' . $label . '</label>
                <select name="' . $fieldName . '" id="' . $fieldName . '">
                    <option disabled selected value> -- maak een keuze -- </option>';
                    if (is_array($options)) {
                        foreach ($options as $key => $label) {
                            echo '
                            <option value="' . $key . '"' . ($data[$fieldName] === $key ? "selected" : "") . '>' . $label . '</option>';
                        }
                    }
                echo '
                </select>
                ';
                break;

            case 'radio':
                echo '
                <legend>' . $label . '</legend>';
                if (is_array($options)) {
                    foreach ($options as $key => $label) {
                    echo '
                    <li>
                            <input type="' . $type . '" id="' . $key . '" name="' . $fieldName . '" value="' . $key . '"' . ($data[$fieldName] === $key ? "checked" : "") . '>
                            <label for="' . $key . '">' . $label . '</label>
                        </li>';
                    }
                }
                break;

            case 'textarea':
                echo '
                <label for="' . $fieldName . '">' . $label . '</label>
                <textarea id="' . $fieldName . '" name="' . $fieldName . '"';
                if (is_array($options)) {
                    foreach ($options as $key => $value) {
                        echo ' ' . $key . '="' . $value . '"';
                    }
                }
                echo '
                >' . $data[$fieldName] . '</textarea>';
                break;
        }

        if (!$optional) {
            echo '
            <span class="error">* ' . $data[$fieldName . 'Err'] . '</span>';
        }

        echo '    
        </li>';
    }

    function showFormEnd($page, $submitButtonText) {
        echo '
            <li>
                <button type="submit" name="page" value="' . $page . '">' . $submitButtonText . '</button>
            </li>
        </ul>
    </form>';
    }

    showFormStart(true);
    showFormField('gender', 'Aanhef:', 'select', $data, GENDERS);
    showFormField('fname', 'Voornaam:', 'text', $data);
    showFormField('lname', 'Achternaam:', 'text', $data);
    showFormField('email', 'E-mailadres:', 'email', $data);
    showFormField('phone', 'Telefoonnummer:', 'text', $data);
    showFormField('preference', 'Op welke manier wilt u bereikt worden?', 'radio', $data, COMM_PREFS);
    showFormField('message', 'Waarover wilt u contact opnemen?', 'textarea', $data, [ 'rows' => 5, 'cols' => 33 ]);
    showFormEnd('contact', 'verstuur');


    // echo '
    // <form method="post" action="index.php">
    //     <p><span class="error"><strong>* Vereist veld</strong></span></p>
    //     <ul class="flex-outer">

    //         <li>
    //             <label for="gender">Aanhef:</label>
    //             <select name="gender" id="gender">
    //             <option disabled selected value> -- maak een keuze -- </option>
    //             <option value="male" ' . ($gender == "male" ? "selected" : "") . '>Dhr.</option>
    //             <option value="female" ' . ($gender == "female" ? "selected" : "") . '>Mvr.</option>
    //             <option value="unspecified" ' . ($gender == "unspecified" ? "selected" : "") . '>Anders</option>
    //             </select>
    //             <span class="error">* ' . $genderErr . '</span>
    //         </li>

    //         <li>
    //             <label for="fname">Voornaam:</label>
    //             <input type="text" id="fname" name="fname" value="' . $fname . '">
    //             <span class="error">* ' . $fnameErr . '</span>
    //         </li>
            
    //         <li>
    //             <label for="lname">Achternaam:</label>
    //             <input type="text" id="lname" name="lname" value="' .$lname . '">
    //             <span class="error">* ' . $lnameErr . '</span>
    //         </li>
            
    //         <li>
    //             <label for="email">E-mailadres:</label>
    //             <input type="email" id="email" name="email" value="' . $email . '">
    //             <span class="error">* ' . $emailErr . '</span>
    //         </li>
            
    //         <li>
    //             <label for="phone">Telefoonnummer:</label>
    //             <input type="tel" id="phone" name="phone" value="' . $phone . '">
    //             <span class="error">* ' . $phoneErr . '</span>
    //         </li>
            
    //         <li>
    //             <legend>Communicatievoorkeur:</legend>
    //             <ul class="flex-inner">
    //                 <li>
    //                     <input type="radio" id="email" name="preference" value="email" ' . ($preference == "email" ? "checked" : "") . '>
    //                     <label for="email">Email</label>
    //                 </li>
    //                 <li>
    //                     <input type="radio" id="phone" name="preference" value="phone" ' . ($preference == "phone" ? "checked" : "") . '>
    //                     <label for="telefoon">Telefoon</label>
    //                 </li>
    //             </ul>
    //             <span class="error">* ' . $preferenceErr . '</span>
    //         </li>
            
    //         <li>
    //             <label for="bericht">Bericht:</label>
    //             <textarea id="message" name="message" rows="5" cols="33">' . $message . '</textarea>
    //             <span class="error">* ' . $messageErr . '</span>
    //         </li>
            
    //         <li>
    //             <button type="submit" name="page" value="contact">Verstuur</button>
    //         </li>
            
    //     </ul>
    // </form>';
}

?>