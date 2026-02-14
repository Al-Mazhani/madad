<?php
class AuthController  extends ControllUser
{
    public $model;
    public $MailerController;
    public function __construct($model, $MailerController)
    {
        $this->model = $model;
        $this->MailerController = $MailerController;
    }
    protected function ProcceDataUser(&$username, &$email, &$password, &$token)
    {
        $username = strtolower(trim(preg_replace("/[^a-zA-Z0-9_]/", '', $username)));
        $email = strtolower(filter_var($email, FILTER_SANITIZE_EMAIL));
        $password = password_hash(trim($password), PASSWORD_BCRYPT);
        $token = $this->Generate4UUID();
    }
    protected function CheckExitEmail($email)
    {

        $resultExitEmail = $this->model->CheckEmailExit($email);
        if ($resultExitEmail && $resultExitEmail['email'] === $email) {
            return ['hasErrorInput' => 'البريد الالكتروني موجود بالفعل'];
        }
        return [];
    }


    private function HeaderToVerfyEmail()
    {
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
        $reustlConfirCode = $this->MailerController->SendMessageToEmail("hgh29171@gmail.com", $email);
        if ($reustlConfirCode){
            $this->SetCookieToUser($token);
        }
        if($this->MailerController->CheckVerifyCode())

        $resultRegister =  $this->model->insert($username, $email, $password, $token, $role);

        if ($resultRegister) {

            if ($role != "admin") {
                $_SESSION['username'] = $username;
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
