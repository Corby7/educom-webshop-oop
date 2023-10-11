<?php
include_once "basic_doc.php";

class ContactThanksDoc extends BasicDoc {
    const GENDERS = array("male" => "Dhr.", "female" => "Mvr.", "unspecified" => "Anders");

    protected function showHeader() {
        echo '
        Contacteer Mij';
    }

    protected function showContent() {
        echo '
        <h2>Beste ' . self::GENDERS[$this->model->gender] . ' ' . $this->model->fname . ' ' . $this->model->lname . ', bedankt voor het invullen van uw gegevens!</h2>
        <h3>Ik zal zo snel mogelijk contact met u opnemen. Ter bevestiging uw informatie:</h3>
        <ul class="submitted_userdata">
            <li><strong>E-mailadres: </strong>' . $this->model->email . '</li>
            <li><strong>Telefoonnummer: </strong>' . $this->model->phone . '</li>
            <li><strong>Communicatievoorkeur: </strong>' . $this->model->preference . '</li>
            <li><strong>Bericht: </strong>' . $this->model->message . '</li>
        </ul>';
    }
}

?>