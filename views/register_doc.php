<?php
include_once "forms_doc.php";

class RegisterDoc extends FormsDoc {

    protected function showHeader() {
        echo '
        Registreer Nu!';
    }

    protected function showContent() {
        $this->showFormStart(true);
        $this->showFormField('fname', 'Voornaam:', 'text', $data);
        $this->showFormField('lname', 'Achternaam:', 'text', $data);
        $this->showFormField('email', 'E-mailadres:', 'email', $data);
        $this->showFormField('pass', 'Wachtwoord:', 'password', $data);
        $this->showFormField('repeatpass', 'Herhaal wachtwoord:', 'password', $data);
        $this->showFormEnd('register', 'verstuur');
    
    }


}

?>