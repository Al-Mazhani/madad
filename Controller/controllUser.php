    <?php

    class ControllUser
    {
        protected $Model;
        public function __construct($Model)
        {
            $this->Model = $Model;
        }

        public function show()
        {
            $allUser = $this->Model->loadAll();
            return $allUser;
        }

        public function findByID($id)
        {
            $detailsUser = $this->Model->findByID($id);
            return $detailsUser;
        }
        public function update($username, $email)
        {
            return $this->Model->update($username, $email);
        }
        
        public function delete($id)
        {
            return $this->Model->delete($id);
        }
        
        public function search($username)
        {
            $resultSearch = $this->Model->search($username);
        }

        private function ProcceDataUser(&$username,&$email,&$password){
            // $password = 
        }
        public function insert($username, $email, $password)
        {
            $username = strtolower(trim($username));
            $email = strtolower(trim($email));
            $password = trim($password);
            $validateRegisterUser = request::validateRegister($username,$email,$password);
            if($validateRegisterUser ){
                return $validateRegisterUser;
            }
            $token = session_id();
            $resultRegister =  $this->Model->insert($username, $email, $password, $token,'user');

            if ($resultRegister) {
                setcookie('remember_token', $token, time() + 86400 * 30, "/");
                $_SESSION['username'] = $username;
                header("Location:home");
                exit();
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
