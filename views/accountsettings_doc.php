<?php
include_once "forms_doc.php";

class AccountSettingsDoc extends FormsDoc {

    protected function showHeader() {
        echo '
        Wachtwoord wijzigen';
    }

    protected function showContent() {
        $this->showFormStart(true);
        $this->showFormField('pass', 'Oud wachtwoord', 'password');
        $this->showFormField('newpass', 'Nieuw wachtwoord', 'password');
        $this->showFormField('repeatpass', 'Herhaal nieuw wachtwoord', 'password');
        $this->showFormEnd('accountsettings', 'Wachtwoord wijzigen');
    }


}

?>