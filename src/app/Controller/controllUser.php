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
        private function validateID($id){
            if(!filter_var($id,FILTER_VALIDATE_INT)){
                header ('location: errorURL');
                exit();
            }
            $cleanID = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
            if($cleanID < 0){
                header ('location: errorURL');
                exit();
            }
            return $cleanID;
        }
        public function findByID($id)
        {
            $id = $this->validateID($id);
            if(is_numeric($id)){

            }
            // $detailsUser = $this->Model->findByID($id);
            // return $detailsUser;
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
        private function ProcceDataUser(&$username,&$email,&$password){
            $username = strtolower(trim($username));
            $email = strtolower(filter_var($email,FILTER_SANITIZE_EMAIL));
            $password = password_hash(trim($password), PASSWORD_BCRYPT);

        }
        public function insert($username, $email, $password)
        {
            $validateRegisterUser = request::validateRegister($username,$email,$password);
            if($validateRegisterUser ){
                return $validateRegisterUser;
            }
            $token = session_id();
            $this->ProcceDataUser($username,$email,$password);
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
