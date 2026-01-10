    <?php

    class ControllUser  extends BaseController
    {
        protected $Model;
        public function __construct($Model)
        {
            $this->Model = $Model;
        }
        private function validateRegister($username, $email, $password)
        {
            $lenghtPassword =  strlen($password);
            $lenghtUserName =  strlen($username);
            if (empty($username)) {
                return ['emptyName' => "يرجاء املاء حقل الاسم"];
            }
            if ($lenghtUserName < 3 || $lenghtUserName >= 30) {
                return ['lenghtUsername' => 'يرجاء ان يكون الاسم بين 3 و 30 حرف'];
            }
            if (empty($email)) {
                return ['emptyEmail' => 'يرجاءاملاء حقل البريد الالكتروني'];
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['invalidEmail' => 'يرجاء املاء حقل البريد'];
            }
            if (empty($password)) {
                return ['emptyPassword' => 'يرجاء إملاء حقل كلمة المرور'];
            }
            if ($lenghtPassword   < 10  && $lenghtPassword >= 15) {
                return ['lenghtPassword' => 'يرجاء املا كلمة المرور  بين 10 و 15 حرف'];
            }
        }
        public function show()
        {
            $allUser = $this->Model->loadAll();
            return $allUser;
        }
  
        public function update($username, $email)
        {
            return $this->Model->update($username, $email);
        }

        public function delete($id)
        {
            $CleanID = $this->validateID($id);

            return $this->Model->delete($id);
        }

        public function search($username)
        {
            $resultSearch = $this->Model->search($username);
        }

        // Clean Data User
        private function ProcceDataUser(&$username, &$email, &$password,&$token)
        {
            $username = strtolower(trim($username));
            $email = strtolower(filter_var($email, FILTER_SANITIZE_EMAIL));
            $password = password_hash(trim($password), PASSWORD_BCRYPT);
            $token = $this->Generate4UUID();
        }
        private function SetCookieAndSessionToUser( $token,$username)
        {
            setcookie('remember_token', $token, time() + 86400 * 30, "/");
            $_SESSION['username'] = $username;
            header("Location:/Madad/");
            exit();
        }
        public function create($username, $email, $password)
        {
            $validateRegisterUser = $this->validateRegister($username, $email, $password);
            if ($validateRegisterUser) {
                return $validateRegisterUser;
            }
            $this->ProcceDataUser($username, $email, $password,$token);
            $resultRegister =  $this->Model->insert($username, $email, $password, $token, 'user');

            if ($resultRegister) {
                $this->SetCookieAndSessionToUser($token,$username);
            } else {
                return ['invalidRegister' => 'فشل انشاء حساب'];
            }
        }
        public function isLoggedIn($email, $password)
        {
            $email = strtolower(trim($email));
            $password = trim($password);
            if (empty($email)) {
                return ['emptyEmail' => 'يرجاء ملاء الحقل'];
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['invalidEmail' => 'غلط في البريد الالكتروني'];
            }
            if (empty($password)) {
                return ['emptyPass' => 'يرجاء ملاء الحقل'];
            }
            $lenghtPassword  = strlen($password);
            if ($lenghtPassword  < 10 || $lenghtPassword >= 15) {
                return ['lenghtPass' => 'يرجاء املا كلمة المرور  بين 10 و 15 حرف'];
            }
            $hashPassword = Encryption($password);

            if ($this->Model->checkLogin($email, $hashPassword)) {
                header("location:home");
                exit();
            } else {
                return ['filedLogin' => 'يرجاء انشاء حساب اولاً'];
            }
        }
        function checkToken($token)
        {
            return  $this->Model->checkToken($token);
        }
    }
