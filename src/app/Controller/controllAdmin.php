<?php
include_once 'ControllUser.php';
class controllAdmin extends ControllUser
{
    public function __construct($Model)
    {
        parent::__construct($Model);
    }

    public function isLoggedIn($email, $password)
    {
        if ($error = $this->validateEmail($email)) {
            return $error;
        }

        if ($error = $this->validatePassword($password)) {
            return $error;
        }
        $resultLogIn = $this->Model->checkLogin($email);
        if (!password_verify($password, $resultLogIn['password'])) {
            return ['filedLogin' => 'انت لست مشرف الموقع'];
        }
        
        $_SESSION['adminName'] = 'role';
        header("location:/Madad/homeAdmin");
        exit();
    }
}
