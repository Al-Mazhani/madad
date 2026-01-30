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

        $resultLogIn = $this->model->checkLogin($email);

        if(!$resultLogIn){
         return ['filedLogin' => 'الحساب غير موجود   '];
        }

        if (!password_verify($password, $resultLogIn['password'])) {
            return ['filedLogin' => 'انت لست مشرف الموقع'];
        }
        
        $_SESSION['adminName'] = $resultLogIn['username'];
        $_SESSION['role'] = "admin";
        header("location:/Madad/homeAdmin");
        exit();
    }
}
