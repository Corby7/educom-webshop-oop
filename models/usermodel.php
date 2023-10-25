<?php
include_once "pagemodel.php";

class UserModel extends PageModel {
    /** Authentication result indicating success. */
    const RESULT_OK = 0;
    /** Authentication result indicating an unknown user. */
    const RESULT_UNKNOWN_USER = -1;
    /** Authentication result indicating a wrong password. */
    const RESULT_WRONG_PASSWORD = -2;

    public function __construct($pageModel, $userCrud) {
        PARENT::__construct($pageModel);
        $this->userCrud = $userCrud;
    }

    private $userCrud;
    private $userid = 0;
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
    public $fieldName = "";

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
    $this->valid = empty($this->genderErr) && empty($this->fnameErr) && empty($this->lnameErr) && empty($this->emailErr) && empty($this->phoneErr) && empty($this->preferenceErr) && empty($this->messageErr);
    }


    public function validateRegister() {
    
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
        
        try {
            if (!empty($this->email) && $this->doesEmailExist($this->email)) {
                $this->emailknownErr = "E-mailadres is reeds bekend";
            }
        } catch (Exception $e) {
            $this->logError("Check if email exists failed: " . $e->getMessage());
            $this->genericErr = "Sorry technisch probleem, e-mailadres kan niet gecheckt worden";
        }
    
        $this->pass = $this->getFilteredPostVar("pass");
        if (empty($this->pass)) {
            $this->passErr = "Wachtwoord is vereist";
        }
    
        $this->repeatpass = $this->getFilteredPostVar("repeatpass");
        if (empty($this->repeatpass)) {
            $this->repeatpassErr = "Wachtwoord herhalen is vereist";
        }
    
        if (empty($this->passErr) && empty($this->repeatpassErr)) {
            $this->passcheckErr = $this->validatePassword($this->pass, $this->repeatpass);
        }
    
        //if no errors found, set username and set valid to true
        $this->valid = (empty($this->fnameErr) && empty($this->lnameErr) && empty($this->emailErr) && empty($this->passErr) && empty($this->repeatpassErr) && empty($this->passcheckErr) && empty($this->emailknownErr));
        
        if ($this->valid) {
            $this->name = $this->fname . ' ' . $this->lname;
        }
    }

    private function doesEmailExist($email) {
        $user = $this->userCrud->readUserByEmail($email);
        return !empty($user);
    }

    public function storeUser() {
        try {
            $user = array('name' => $this->name, 'email' => $this->email , 'password' => $this->pass);
            $this->userCrud->createUser($user);
            $this->genericMsg = "Registratie succesvol";
        } catch (Exception $e) {
            $this->logError("Store user failed: " . $e->getMessage());
            $this->genericErr = "Sorry technisch probleem, gegevens opslaan niet mogelijk";
        }
    }    

    public function validateLogin() {
    
        $this->email = $this->getFilteredPostVar("email");
        if (empty($this->email)) {
            $this->emailErr = "Email is vereist";
        }
    
        $this->pass = $this->getFilteredPostVar("pass");
        if (empty($this->pass)) {
            $this->passErr = "Wachtwoord is vereist";
        }
    
        if (empty($this->emailErr) && empty($this->passErr)) {
            try {
                $result = $this->authenticateUser();
    
                switch($result['result']) {
                    case UserModel::RESULT_UNKNOWN_USER:   
                        $this->emailunknownErr = "E-mailadres is onbekend";
                        break;
                    case UserModel::RESULT_WRONG_PASSWORD:
                        $this->wrongpassErr = "Wachtwoord is onjuist";
                        break;
                    case UserModel::RESULT_OK:
                        $this->valid = true;
                        $this->username = $result['user']->name;
                        $this->useremail = $result['user']->email;
                        $this->userid = $result['user']->id;
                        break;
                }
            } catch (Exception $e) {
                $this->logError("Login failed: " . $e->getMessage());
                $this->genericErr = "Sorry technisch probleem, inloggen niet mogelijk";
            }
        }
    }

    function validateAccountSettings() {

        $this->pass = $this->getFilteredPostVar("pass");
        if (empty($this->pass)) {
            $this->passErr = "Wachtwoord is vereist";
        }
    
        $this->newpass = $this->getFilteredPostVar("newpass");
        if (empty($this->newpass)) {
            $this->newpassErr = "Nieuw wachtwoord is vereist";
        }
    
        $this->repeatpass = $this->getFilteredPostVar("repeatpass");
        if (empty($this->repeatpass)) {
            $this->repeatpassErr = "Wachtwoord herhalen is vereist";
        }
    
        if (empty($this->newpassErr) && ($this->pass === $this->newpass)) {
            $this->oldvsnewpassErr = "Nieuw wachtwoord mag niet hetzelfde zijn als uw oude wachtwoord";
        }
    
        if (empty($this->passErr) && empty($this->newpassErr) && empty($this->repeatpassErr) && empty($this->oldvsnewpassErr)) {
            $this->passcheckErr = $this->validatePassword($this->newpass, $this->repeatpass);
        
            if (empty($this->passcheckErr)) {
                try {
                    $this->email = $this->sessionManager->getLoggedInUserEmail();
                    $result = $this->authenticateUser();
    
                    switch($result['result']) {
                        case UserModel::RESULT_WRONG_PASSWORD;
                            $this->wrongpassErr = "Wachtwoord is onjuist";
                            break;
                        case UserModel::RESULT_OK;
                            $this->valid = true;
                            break;
                    }
                } catch (Exception $e) {
                    $this->logError("Password verify failed: " . $e->getMessage());
                    $this->genericErr = "Sorry technisch probleem, wachtwoord kan niet worden geverifieerd";
                }
            }
        }
    }

    public function validatePassword($pass, $repeatpass) {
        if ($pass !== $repeatpass) {
            return "Wachtwoorden komen niet overeen";
        }
        return '';
    }
    

    private function authenticateUser() {
        $user = $this->userCrud->readUserByEmail($this->email);

        //password validatie
        if(empty($user)) {
            return ['result' => UserModel::RESULT_UNKNOWN_USER];
        }
    
        if ($user->password !== $this->pass) {
            return ['result' => UserModel::RESULT_WRONG_PASSWORD];
        }
    
        return ['result' => UserModel::RESULT_OK, 'user' => $user];
    }

    public function doLoginUser() {
        $this->sessionManager->doLoginUser($this->username, $this->useremail, $this->userid);
        $this->genericMsg = "Login succesvol";
    }

    public function doLogoutUser() {
        $this->sessionManager->doLogoutUser();
        $this->genericMsg = "Uitgelogd";
    }

    public function updatePasswordByEmail() {
        try {
            $this->userid = $this->sessionManager->getLoggedInUserId();
            $this->userCrud->updateUserPassword($this->userid, $this->newpass);
            $this->genericMsg = "Wachtwoord successvol gewijzigd.";
        } catch (Exception $e) {
            $this->logError("Overwriting password failed: " . $e->getMessage());
            $this->genericErr = "Sorry, technische storing. Wachtwoord wijzigen niet mogelijk.";
        }
    }


}

?>