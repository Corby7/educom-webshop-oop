<?php
include_once "basic_doc.php";

abstract class FormsDoc extends BasicDoc {

    protected function showFormStart($hasRequiredFields) {
        echo'
        <form method="post" action="index.php">';
            if ($hasRequiredFields) {
                echo'
                <span class="alert alert-danger d-inline-block text-danger py-1" role="alert">* Vereist veld</span>';
            }
    }

    protected function showFormField($fieldName, $label, $type, $options = NULL, $optional = false) {
 
        switch($type) {
           
            case 'select':
                echo '
                <div class="mb-3 form-outline w-50">
                    <label for="gender" class="form-label fs-5">Aanhef<span class="text-danger d-inline-block">*</span></label>
                    <select class="form-select" name="' . $fieldName . '" id="' . $fieldName . '">
                        <option disabled selected value> -- maak een keuze -- </option>';
                        if (is_array($options)) {
                            foreach ($options as $key => $label) {
                                echo '
                                <option value="' . $key . '"' . ($this->model->{$fieldName} === $key ? "selected" : "") . '>' . $label . '</option>';
                            }
                        }
                    echo '
                    </select>
                ';
                break;
    
            case 'radio':
                echo '
                <fieldset class="mb-3 form-outline w-50">
                    <legend class="form-label fs-5">' . $label . '<span class="text-danger d-inline-block">*</span></legend>';
                    if (is_array($options)) {
                        foreach ($options as $key => $label) {
                            $optionId = $fieldName . '_' . $key;
                            echo '
                            <div class="form-check">
                                <input class="form-check-input" type="' . $type . '" id="' . $optionId . '" name="' . $fieldName . '" value="' . $key . '"' . ($this->model->{$fieldName} === $key ? "checked" : "") . '>
                                <label class="form-check-label" for="' . $optionId . '">' . $label . '</label>
                            </div>';
                            }
                    }
                break;
    
            case 'textarea':
                echo '
                <div class="mb-3 form-outline w-50">
                    <label for="bericht" class="form-label fs-5">Bericht<span class="text-danger d-inline-block">*</span></label>
                    <textarea class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" rows="5">' . $this->model->{$fieldName} . '</textarea>';
                break;

            default:
                echo '
                <div class="form-floating mb-3 form-outline w-50">
                    <input type="' . $type . '" class="form-control" placeholder="' . $label . '" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $this->model->{$fieldName} . '">
                    <label for="' . $fieldName . '" class="form-label"><span class="text-secondary">' . $label . '</span><span class="text-danger d-inline-block">*</span></label>';
                break;
        
        }
    
        if (!$optional && isset($this->model->{$fieldName . 'Err'}) && !empty($this->model->{$fieldName . 'Err'})) {
            echo '<span class="text-danger">' . $this->model->{$fieldName . 'Err'} . '</span>';
        }

    
        if (!$optional) {
            $extraErrors = [
                'email' => ['emailknownErr', 'emailunknownErr'],
                'repeatpass' => ['passcheckErr'],
                'pass' => ['wrongpassErr', 'oldvsnewpassErr'],
            ];
        
            if (isset($extraErrors[$fieldName])) {
                foreach ($extraErrors[$fieldName] as $errorKey) {
                    if (!empty($this->model->{$errorKey})) {
                        echo '<span class="error">* ' . $this->model->{$errorKey} . '</span>';
                    }
                }
            }
        }
    
        if ($type == 'radio') {
            echo '</fieldset>';
        } else {
            echo '</div>';
        }
    }
    
    protected function showFormEnd($page, $submitButtonText) {
        echo '
        <button type="submit" class="btn btn-primary" id="button-invert" name="page" value="' . $page . '">' . $submitButtonText . '</button>
    </form>';
    }
    
}

?>