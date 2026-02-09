<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControllUser  extends BaseController
{
    protected $mailer;
    public function __construct($model)
    {
        $mailer = new PHPMailer(true);
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
    public function validatePassword($password)
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
    private function ProcceDataUser(&$username, &$email, &$password, &$token)
    {
        $username = strtolower(trim(preg_replace("/[^a-zA-Z0-9_]/", '', $username)));
        $email = strtolower(filter_var($email, FILTER_SANITIZE_EMAIL));
        $password = password_hash(trim($password), PASSWORD_BCRYPT);
        $token = $this->Generate4UUID();
    }
    private function SetCookieToUser($token)
    {
        setcookie('remember_token', $token, time() + 86400 * 30, "/");
        header("Location:/Madad/");
        exit();
    }
    private function CheckExitEmail($email)
    {

        $resultExitEmail = $this->model->CheckEmailExit($email);
        if ($resultExitEmail['email'] === $email) {
            return ['hasErrorInput' => 'البريد الالكتروني موجود بالفعل'];
        }
        return [];
    }

    //  confirm Code Email 
    public function GetCodeEmail($Code)
    {
        if ($Code != $_SESSION['confrim-code']) {
            return false;
        }
        return true;
    }
    protected function MakeCodeForEmail()
    {
        return random_int(100000, 999999);
    }
    protected  function MessageConfrimCode($code)
    {
        return '    <div class="message-code">
        <img src="public/images/iconMidad.png" alt="">
         <h2>كود التحقق الخاص بك </h2>
         <p> استخدم هذا الكود لتأكيد بريدك الإلكتروني.</p>
         <b> ' . $code . '</b>
         <p>سينتهي هذا الكود بعد 10 دقائق.</p>
    </div>';
    }
    public function SettingSMTP($SendEmailFrom)
    {
        try {

            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $SendEmailFrom;
            $this->mailer->Password = 'whshtreawzhshmwy';
            $this->mailer->SMTPSecure = 'tls';
            $this->mailer->Port = 587;
        } catch (Exception $e) {
            return ['hasInputEmpty' => 'لم يتم إرسال الرمز'];
        }
    }
    public function SendMessageToEmail($SendEmailFrom, $userEmail, $code)
    {
        if ($ErrorSendCode = $this->SettingSMTP($SendEmailFrom)) {
            return $ErrorSendCode;
        }
        $this->mailer->setFrom($SendEmailFrom, 'Madad');
        $this->mailer->addAddress($userEmail);

        $this->mailer->isHTML(true);
        $this->mailer->Subject = 'Madad verification code';
        $this->mailer->Body = $this->MessageConfrimCode($code);
        $this->mailer->send();

        return [];
    }
    protected function CheckVerifyCode() {}
    private function lockedAccount()
    {
        die("account locked try later");
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

                $this->SetCookieToUser($token);
            }
        } else {
            return ['invalidRegister' => 'فشل انشاء حساب'];
        }
    }
    public function LogOut()
    {

        setcookie('remember_token', '', time() - 3600, "/");
        header("Location:/Madad/");
        exit();
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
            // unset($_SESSION['CounterLogginUser']);
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

    public function checkToken($token)
    {
        $getToken = $this->model->checkToken($token);
        if (!empty($getToken)) {

            $_SESSION['user_id'] = $getToken['user_id'];
            $_SESSION['username'] = $getToken['username'];
            $_SESSION['email'] = $getToken['email'];
        }
    }
}
