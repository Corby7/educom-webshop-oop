<?php
include_once "forms_doc.php";

class LoginDoc extends FormsDoc {

    protected function showHeader() {
        echo '
        Login';
    }

    protected function showContent() {
        $this->showFormStart(true);
        $this->showFormField('email', 'E-mailadres:', 'email', $data);
        $this->showFormField('pass', 'Wachtwoord:', 'password', $data);
        $this->showFormEnd('login', 'Inloggen');
    }


}

?>