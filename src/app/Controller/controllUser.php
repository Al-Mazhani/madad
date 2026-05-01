<?php
//   include("../classas/clsUser.php");
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
            return ['hasErrorInput' => "يرجاء املاء حقل الاسم"];
        }
        if ($lenghtUserName < 3 || $lenghtUserName > 30) {
            return ['hasErrorInput' => 'يرجاء ان يكون الاسم بين 3 و 30 حرف'];
        }
        if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {

            return ['hasErrorInput' => " [ a - z A - Z 0 - 9 _ ] {  3 , 20 } يرجاء املاء حقل الاسم"];
        }

        return [];
    }
    private function _MapToUser($LineUser)
    {
        return new clsUser($LineUser['user_id'], $LineUser['username'], $LineUser['email'], $LineUser['password'], (int)$LineUser['role'], (bool)$LineUser['active_user'], $LineUser['token'], $LineUser['created_at'], $LineUser['image'], $LineUser['background_image']);
    }
    public function validateEmail($email)
    {

        if (empty($email)) {
            return ['hasErrorInput' => 'يرجاءاملاء حقل البريد الالكتروني'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['hasErrorInput' => 'يرجاء املاء حقل البريد'];
        }
        return [];
    }
    public function validatePassword(&$password)
    {
        $lenghtPassword =  strlen($password);
        if (empty($password)) {
            return ['hasErrorInput' => 'يرجاء إملاء حقل كلمة المرور'];
        }
        if ($lenghtPassword   < 10  || $lenghtPassword > 15) {
            return ['hasErrorInput' => 'يرجاء املا كلمة المرور  بين 10 و 15 حرف'];
        }
        return [];
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

        $User =  $this->_MapToUser($this->model->checkToken($token));
        $this->_MakeSessionForUser($User);
        return true;
    }
}
