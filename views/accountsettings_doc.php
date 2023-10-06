<?php
include_once "forms_doc.php";

class AccountsettingsDoc extends FormsDoc {

    protected function showHeader() {
        echo '
        Wachtwoord wijzigen';
    }

    protected function showContent() {
        $this->showFormStart(true);
        $this->showFormField('pass', 'Oud wachtwoord:', 'password', $data);
        $this->showFormField('newpass', 'Nieuw wachtwoord:', 'password', $data);
        $this->showFormField('repeatpass', 'Herhaal nieuw wachtwoord:', 'password', $data);
        if (isset($data['passwordUpdated'])) {
            echo '<span class="success">' . $data['passwordUpdated'] . '</span>';
        }
        $this->showFormEnd('settings', 'Wachtwoord wijzigen');
    }


}

?>