<?php
include_once "pagemodel.php";

class UserModel extends PageModel {
    private $userId = 0;
    public $valid = false;

    // Fields for 'contact'
    public $gender = "";
    public $fname = "";
    public $lname = "";
    public $email = "";
    public $phone = "";
    public $preference = "";
    public $message = "";
    public $genderErr = "";
    public $fnameErr = "";
    public $lnameErr = "";
    public $emailErr = "";
    public $phoneErr = "";
    public $preferenceErr = "";
    public $messageErr = "";

    // Fields for 'register'
    public $name = "";
    public $pass = "";
    public $repeatpass = "";
    public $passErr = "";
    public $repeatpassErr = "";
    public $passcheckErr = "";
    public $emailknownErr = "";
    public $emailunknownErr = "";
    public $wrongpassErr = "";

    // Fields for 'login'
    public $username = "";
    public $useremail = "";

    // Fields for 'accountsettings'
    public $newpass = "";
    public $oldvsnewpassErr = "";
    public $passwordUpdated = "";

    public function __construct($pageModel) {
        PARENT::__construct($pageModel);
    }

    public function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function getFilteredPostVar($key, $default='') {
        return $this->testInput($this->getPostVar($key, $default));
     }
    
    public function validateContact() {
    //retrieve and sanitize the fields from $_POST
    $this->gender = $this->getFilteredPostVar("gender");
    if (empty($this->gender)) {
        $this->genderErr = "Aanhef is vereist";
    }
    
    $this->fname = $this->getFilteredPostVar("fname");
    if (empty($this->fname)) {
        $this->fnameErr = "Voornaam is vereist";
    }
    
    $this->lname = $this->getFilteredPostVar("lname");
    if (empty($this->lname)) {
        $this->lnameErr = "Achternaam is vereist";
    }
    
    $this->email = $this->getFilteredPostVar("email");
    if (empty($this->email)) {
        $this->emailErr = "Email is vereist";
    }
    
    $this->phone = $this->getFilteredPostVar("phone");
    if (empty($this->phone)) {
        $this->phoneErr = "Telefoonnummer is vereist";
    }
    
    $this->preference = $this->getFilteredPostVar("preference");
    if (empty($this->preference)) {
        $this->preferenceErr = "Voorkeur is vereist";
    }
    
    $this->message = $this->getFilteredPostVar("message");
    if (empty($this->message)) {
        $this->messageErr = "Bericht is vereist";
    }
    
    //check if there are any errors and set $valid accordingly
    $this->valid = empty($this->genderErr) && empty($this->fnameErr) && empty($this->lnameErr) && empty($this->emailErr) && empty($this->phoneErr) && empty(this->preferenceErr) && empty($this->messageErr);
    }

    public function validateLogin() {
        //...{
            $this->valid = true;
        //}
    }

    private function authenticateUser() {
        require_once "../mysqlconnect.php";
        $user = findUserByEmail($this->email);

        //password validatie

        $this->name = $user['name'];
        $this->userId = $user['id'];
    }

    public function doLoginUser() {
        $this->sessionManager->doLoginUser($this->name, $this->userId);
        $this->genericErr = "Login succesvol";

    }





}

?>