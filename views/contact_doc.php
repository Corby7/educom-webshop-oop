<?php
include_once "forms_doc.php";

class ContactDoc extends FormsDoc {
    const GENDERS = array("male" => "Dhr.", "female" => "Mvr.", "unspecified" => "Anders");
    const COMM_PREFS = array("email" => "E-Mail", "phone" => "Telefoon");

    protected function showHeader() {
        echo '
        Contacteer Mij';
    }

    protected function showContent() {
        $this->showFormStart(true);
        $this->showFormField('gender', 'Aanhef:', 'select', $data, self::GENDERS);
        $this->showFormField('fname', 'Voornaam:', 'text', $data);
        $this->showFormField('lname', 'Achternaam:', 'text', $data);
        $this->showFormField('email', 'E-mailadres:', 'email', $data);
        $this->showFormField('phone', 'Telefoonnummer:', 'text', $data);
        $this->showFormField('preference', 'Op welke manier wilt u bereikt worden?', 'radio', $data, self::COMM_PREFS);
        $this->showFormField('message', 'Waarover wilt u contact opnemen?', 'textarea', $data, [ 'rows' => 5, 'cols' => 33 ]);
        $this->showFormEnd('contact', 'verstuur');
    }


}

?>