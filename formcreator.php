<?php


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
        case 'password':
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

    if (!empty($extraErrors)) {
        foreach ($extraErrors as $error) {
            echo '
            <span class="error">* ' . $error . '</span>';
        }
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


?>