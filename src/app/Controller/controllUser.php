<?php

//   include("../classas/clsUser.php");

enum enUserInputErrors: int
{
    case  MissinUsername = 1;
     case   LanthUserName = 2;
     case   InvalidUsername = 3;
     case  MissinPassword = 4;
     case  LenghtPassword = 5;
     case   MissinImage = 6;
     case   MissinBackgroundImage = 7;
     case   MissinToken = 8;
     case  InvalidEmail = 9;
     case NoErrors = 10;
     };
class ControllUser  extends BaseController
{
    public function __construct($model)
    {
        parent::__construct($model);
    }

    public  function ValidateInputUsername($username)
    {
        $lenghtUserName =  strlen($username);
        if (empty($username)) {
            return enUserInputErrors::MissinUsername;
        }
        if ($lenghtUserName < 3 || $lenghtUserName > 30) {
            return enUserInputErrors::LanthUserName;
        }
        if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {

            return enUserInputErrors::InvalidUsername;
        }

        return enUserInputErrors::NoErrors;
    }

    public function validateEmail($email)
    {

        if (empty($email)) {
            return enUserInputErrors::InvalidEmail;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return enUserInputErrors::InvalidEmail;
        }
        return enUserInputErrors::NoErrors;
    }
    public function validatePassword($password)
    {
        $lenghtPassword =  strlen($password);
        if (empty($password)) {
            return enUserInputErrors::MissinPassword;
        }
        if ($lenghtPassword   < 10  || $lenghtPassword > 15) {
            return enUserInputErrors::LenghtPassword;
        }
        return enUserInputErrors::NoErrors;
    }
    public function show()
    {
        return $this->model->loadAll();
    }

    public function updateProfile($username, $email)
    {
        if ($errorUsername = $this->ValidateInputUsername($username)) {
            return $errorUsername;
        }

        if ($errorEmail = $this->validateEmail($email)) {
            return $errorEmail;
        }
        if (!$this->model->update($username, $email)) {
            return ['updatedProfileFields' => "فشل في تعديل اسمك"];
        }
        return ['updateProfileSuccess' => "تم تحديث اسمك"];
    }
    // Clean Data User



    //  confirm Code Email 


    private function lockedAccount()
    {
        if (!isset($_SESSION['AccountLocked'])) {
            $_SESSION['AccountLocked'] = true;
        }

        die("Account Locked");
    }

    private function CheckIfLogginThen5Times()
    {
        $allowedLoggin = 5;
        if ($_SESSION['CounterLogginUser'] > $allowedLoggin) {
            $this->lockedAccount();
        }
    }
    protected function CountAllowedLoggin()
    {

        if (!isset($_SESSION['frist_ip_loggin'])) {

            $_SESSION['frist_ip_loggin'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['CounterLogginUser'] = 0;
        }

        if ($_SESSION['frist_ip_loggin'] == $_SERVER['REMOTE_ADDR'] && isset($_SESSION['CounterLogginUser'])) {

            $_SESSION['CounterLogginUser']++;
            $this->CheckIfLogginThen5Times();
        }
    }

    public function LogOut()
    {

        setcookie('remember_token', '', time() - 3600, "/");
        header("Location:/Madad/");
        exit();
    }
    private function _MakeSessionForUser($User)
    {
        $_SESSION['user_id'] = $User->ID();
        $_SESSION['username'] = $User->Username();
        $_SESSION['email'] = $User->Email();
        $_SESSION['Role'] = $User->Role();
        $_SESSION['Active'] = $User->Active();
        $_SESSION['Image'] = $User->Image();
        $_SESSION['BackgroundImage'] = $User->BackgroundImage();
    }
    public function checkToken($token)
    {

        // $User =  clsUser::Find($this->model->checkToken($token));
        // $this->_MakeSessionForUser($User);
        return true;
    }
}
