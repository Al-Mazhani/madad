<?php
class AuthController  extends ControllUser
{
    public $model;
    public $MailerController;
    public function __construct($model)
    {
        $this->model = $model;
    }
    
    protected function ProcceDataUser(&$username, &$email, &$password, &$token)
    {
        // $username =  $this->CleanUserName($username);
        // $email = $this->CleanEmail($email);
        // $password = $this->CleanPassword($password);
        // $token = $this->Generate4UUID();
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
    public static function AddUser(string $Username,string $Email, string $Password)
    {
        $User = clsUser::GetAddNewUser($Email);
        $User->setUsername($Username);
        $User->setPassword($Password);
        $User->setPassword("user");
        $ResultValidateInput = $User->ValidateDataUser();
        return $User->Save();
        
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


        if ($this->model->changePassword($passwords['newPassword'], $_SESSION['email'])) {

            return ['SescesChangePassword' => "تم تغير كلمة المرور"];
        } else {
            return ['InvaludChangePassword' => "كلمة المرور غير صحيحة"];
        }
    }
    public static function ShowRegisterResult($RegisterResult)
    {
        // Check For Errors
        
    }
}
