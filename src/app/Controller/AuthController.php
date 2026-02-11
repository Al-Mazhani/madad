<?php
class AuthController  extends ControllUser
{
    public $model;
    public function __construct($model)
    {
        $this->model = $model;
    }
    protected function ProcceDataUser(&$username, &$email, &$password, &$token)
    {
        $username = strtolower(trim(preg_replace("/[^a-zA-Z0-9_]/", '', $username)));
        $email = strtolower(filter_var($email, FILTER_SANITIZE_EMAIL));
        $password = password_hash(trim($password), PASSWORD_BCRYPT);
        $token = $this->Generate4UUID();
    }

    private function HeaderToVerfyEmail() {
        header('Location:/Madad/verify-email');
    }
    public function create($username, $email, $password, $role)
    {
        if ($errorUsername = $this->ValidateInputUsername($username)) {
            return $errorUsername;
        }
        if ($errorEmail = $this->validateEmail($email)) {
            return $errorEmail;
        }
        if ($errorExitEmail = $this->CheckExitEmail($email)) {
            return $errorExitEmail;
        }
        if ($errorPassword = $this->validatePassword($password)) {
            return $errorPassword;
        }
        // Send Code To User Email
        $this->ProcceDataUser($username, $email, $password, $token);

        $resultRegister =  $this->model->insert($username, $email, $password, $token, $role);

        if ($resultRegister) {

            if ($role != "admin") {
                $_SESSION['username'] = $username;
                
                $this->HeaderToVerfyEmail();
            }
        } else {
            return ['invalidRegister' => 'فشل انشاء حساب'];
        }
    }
    public function isLoggedIn($email, $password)
    {
        if ($errorEmail = $this->validateEmail($email)) {
            return $errorEmail;
        }

        if ($errorPassword = $this->validatePassword($password)) {
            return $errorPassword;
        }

        $userLogggedIn = $this->model->checkLogin($email);
        if (!$userLogggedIn) {

            $this->CountAllowedLoggin();
            return ['filedLogin' => 'يرجاء انشاء حساب اولاً'];
        }
        if (password_verify($password, $userLogggedIn['password'])) {

            $token = $this->Generate4UUID();

            if ($this->model->updateToken($token, $email)) {

                $this->SetCookieToUser($token);
            }
        } else {

            return ['filedLogin' => 'يرجاء انشاء حساب اولاً'];
        }
    }
}
