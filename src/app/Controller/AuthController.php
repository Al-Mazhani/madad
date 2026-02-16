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


    private function HeaderToPageVerfyEmail()
    {
        header('Location:/Madad/verify-email');
    }
    private function HeaderToDashbord()
    {
        header("location:/homeAdmin");
        exit();
    }
    protected function SetCookieToUser($token)
    {
        setcookie('remember_token', $token, time() + 86400 * 30, "/");
        header("Location:/Madad/");
        exit();
    }
    public function CheckVerifyCode()
    {
        if (isset($_SESSION['code-from-form'], $_SESSION['confrim-code'])) {
            echo $_SESSION['code-from-form'] . " " . $_SESSION['confrim-code'];

            return $_SESSION['code-from-form'] == $_SESSION['confrim-code'] ? true : false;
        }
        return false;
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
        $Subject = 'Madad verification code';

        $this->ProcceDataUser($username, $email, $password, $token);
        $emailSend = "hgh29171@gmail.com";
        $reustlConfirCode = $this->MailerController->SendMessageToEmail($emailSend, $email, $Subject);
        if (isset($reustlConfirCode['hasInputEmpty'])) {
            return $reustlConfirCode['hasInputEmpty'];
        }
        $resultCode = 0;
        if (isset($_SESSION['code-from-form'], $_SESSION['confrim-code'])) {
            echo $_SESSION['code-from-form'] . " " . $_SESSION['confrim-code'];

            $resultCode =  $_SESSION['code-from-form'] == $_SESSION['confrim-code'] ? true : false;
        }
        if (!$resultCode) {
            return ['hasInputEmpty' => 'عفواً الرمز غير صحيح'];
        }
        $resultRegister =  $this->model->insert($username, $email, $password, $token, $role);

        if ($resultRegister) {
            $this->SetCookieToUser($token);

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

            if ($this->model->updateToken($token, $email) && $userLogggedIn['role'] = 'user') {

                $this->SetCookieToUser($token);
            }
            if ($userLogggedIn['role'] == 'Admin') {
                $this->HeaderToDashbord();
            }
        } else {

            return ['filedLogin' => 'يرجاء انشاء حساب اولاً'];
        }
    }
}
