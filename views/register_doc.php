<?php
include_once "forms_doc.php";

class RegisterDoc extends FormsDoc {

    protected function showHeader() {
        echo '
        Registreer Nu!';
    }

    protected function showContent() {
        $this->showFormStart(true);
        $this->showFormField('fname', 'Voornaam', 'text');
        $this->showFormField('lname', 'Achternaam', 'text');
        $this->showFormField('email', 'E-mailadres', 'email');
        $this->showFormField('pass', 'Wachtwoord', 'password');
        $this->showFormField('repeatpass', 'Herhaal wachtwoord', 'password');
        $this->showFormEnd('register', 'Registreren');

    }


}

?>