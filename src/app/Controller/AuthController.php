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
        $username =  $this->CleanUserName($username);
        $email = $this->CleanEmail($email);
        $password = $this->CleanPassword($password);
        $token = $this->Generate4UUID();
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
    public function create($Username, $Email, $Password)
    {
        if ($errorUsername = $this->ValidateInputUsername($Username)) {
            return $errorUsername;
        }
        if ($errorEmail = $this->validateEmail($Email)) {
            return $errorEmail;
        }
        if ($errorPassword = $this->validatePassword($Password)) {
            return $errorPassword;
        }

        // Send Code To User Email

        $this->ProcceDataUser($Username, $Email, $Password, $Token);
  
        try {

            if (clsUser::IsUserExist($Email)) {
                return SaveResult::EmailExists;
            }
            $user = clsUser::GetAddNewUser($Email);
            $user->setUsername($Username);
            $user->setPassword($Password);
            $user->setToke($Token);
            $user->setRole("admin");
            print_r($user);
            $SaveResult = $user->Save();
            if ($SaveResult == SaveResult::SucceedSave) {
                $this->SetCookieToUser($Token);
            } else {
                return enSaveIntoDB::failSave;
            }
        } catch (Exception $e) {
            return enSaveIntoDB::failSave;
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


        if ($this->model->changePassword($passwords['newPassword'], $_SESSION['email'])) {

            return ['SescesChangePassword' => "تم تغير كلمة المرور"];
        } else {
            return ['InvaludChangePassword' => "كلمة المرور غير صحيحة"];
        }
    }
    public static function ShowRegisterResult($RegisterResult)
    {
        // Check For Errors
        switch ($RegisterResult) {

            case enUserInputErrors::InvalidUsername:
                {
                    return '<span>  "  خطاء في  اسم المستخدم"  </span>';
                }
            case enUserInputErrors::LanthUserName:
                {
                    return '<span>  " يرجاء إدخال اسم المستخدم"  </span>';
                }
            case enUserInputErrors::MissinUsername:
                {
                    return '<span>  " يرجاء إدخال اسم المستخدم"  </span>';
                }
            case enUserInputErrors::InvalidEmail:
                {
                    return '<span>  "  البريد الالكتروني غير صحيح"  </span>';
                }
            case enUserInputErrors::MissinPassword:
                {
                    return '<span>  "يرجاء إدخال كلمة المرور"  </span>';
                }
            case enUserInputErrors::LenghtPassword:
                {
                    return '<span>  "Lneght Password"  </span>';
                }

        }
        // Check For DB
        switch ($RegisterResult) {
            case enSaveIntoDB::EmailExists:
                {
                    return '<span>  "البريد الالكتروني موجود بالفعل" </span>';
                }
            case enSaveIntoDB::failSave:
                {
                    return '<span> "خطاء في انشاء حساب! حاول مرة اخرى"  </span>';
                }
        }
    }
}
