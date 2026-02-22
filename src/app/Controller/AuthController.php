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
    private function CleanUserName(&$username)
    {
        return strtolower(trim(preg_replace("/[^a-zA-Z0-9_]/", '', $username)));
    }
    private function CleanEmail(&$email)
    {
        return strtolower(filter_var($email, FILTER_SANITIZE_EMAIL));
    }
    private function CleanPassword(&$password)
    {
        return password_hash(trim($password), PASSWORD_BCRYPT);
    }
    protected function ProcceDataUser(&$username, &$email, &$password, &$token)
    {
        $username =  $this->CleanUserName($username);
        $email = $this->CleanEmail($email);
        $password = $this->CleanPassword($password);
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
        header("Location:/");
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

        $this->ProcceDataUser($username, $email, $password, $token);
        try {

            $resultRegister = $this->model->insert($username, $email, $password, $token, $role);

            if ($resultRegister) {
                $this->SetCookieToUser($token);
            } else {
                return ['invalidRegister' => 'فشل انشاء حساب'];
            }
        } catch (Exception $e) {
            return ['invalidRegister' => 'حدث خطأ أثناء التسجيل'];
        }
    }
    private function refreshLoginToken($email)
    {
        $token = $this->Generate4UUID();

        if ($this->model->updateToken($token, $email)) {

            $this->SetCookieToUser($token);
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


            if ($userLogggedIn['role'] == 'user') {

                $this->refreshLoginToken($email);
            }
            if ($userLogggedIn['role'] == 'Admin') {
                $this->HeaderToDashbord();
            }
        } else {

            return ['filedLogin' => '   كلمة المرور غير صحيحة'];
        }
    }
    private function idantaclPassword($passwords)
    {
        return !($passwords['newPassword'] == $passwords['configPassword']);
    }
    private function CheckPasswordForChange($passwords)
    {

        if ($errorPassword = $this->validatePassword($passwords['oldPassword'])) {

            return $errorPassword;
        }
        if ($errorPassword = $this->validatePassword($passwords['newPassword'])) {
            return $errorPassword;
        }
        if ($errorPassword = $this->validatePassword($passwords['configPassword'])) {
            return $errorPassword;
        }
        if ($this->idantaclPassword($passwords)) {
            return ['NOTSamePassword' => 'كلمة المرور ليست مشابة'];
        }
    }
    private function ProcessPasswordToChangeIt(&$passwords)
    {
        $passwords['newPassword'] = $this->CleanPassword($passwords['newPassword']);
    }
    public function ChangePassword($passwords)
    {
        if ($errorPassword = $this->CheckPasswordForChange($passwords)) {
            return $errorPassword;
        }
        $this->ProcessPasswordToChangeIt($passwords);


        return ($this->model->changePassword($passwords['newPassword'],$_SESSION['email'])) ? ['SescesChangePassword' => "تم تغير كلمة المرور"] : ['InvaludChangePassword' => "كلمة المرور غير صحيحة"];
    }
}
