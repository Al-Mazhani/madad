<?php
class ControllUser  extends BaseController
{
 protected $Model;
 public function __construct($Model)
 {
     $this->Model = $Model;
     parent::__construct($Model);
 }
 public  function ValidateInputUsername($username)
 {
     $lenghtUserName =  strlen($username);
     if (empty($username)) {
         return ['emptyName' => "يرجاء املاء حقل الاسم"];
     }
     if ($lenghtUserName < 3 || $lenghtUserName >= 30) {
         return ['lenghtUsername' => 'يرجاء ان يكون الاسم بين 3 و 30 حرف'];
     }

     }
     public function validateEmail($email){
         
         if (empty($email)) {
             return ['emptyEmail' => 'يرجاءاملاء حقل البريد الالكتروني'];
         }
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             return ['invalidEmail' => 'يرجاء املاء حقل البريد'];
         }
 }
 public function validatePassword($password)
 {
     $lenghtPassword =  strlen($password);
     if (empty($password)) {
         return ['emptyPassword' => 'يرجاء إملاء حقل كلمة المرور'];
     }
     if ($lenghtPassword   < 10  || $lenghtPassword >= 15) {
         return ['lenghtPassword' => 'يرجاء املا كلمة المرور  بين 10 و 15 حرف'];
     }
 }
 private function validateRegister($username, $email, $password) {}
 public function show()
 {
     $allUser = $this->Model->loadAll();
     return $allUser;
 }
 public function update($username, $email)
 {
     $this->ValidateInputUsername($username);
     $this->validateEmail($email);
     return $this->Model->update($username, $email);
 }
 public function search($username)
 {
     $resultSearch = $this->Model->search($username);
 }
 // Clean Data User
 private function ProcceDataUser(&$username, &$email, &$password, &$token)
 {
     $username = strtolower(trim($username));
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
 public function create($username, $email, $password, $role)
 {
     if($error = $this->ValidateInputUsername($username)){
         return $error;
     }
     if($error = $this->validateEmail($email)){
         return $error;
     }
     if($error = $this->validatePassword($password)){
         return $error;
     }
     $this->ProcceDataUser($username, $email, $password, $token);

     $resultRegister =  $this->Model->insert($username, $email, $password, $token, $role);

     if ($resultRegister) {

        $_SESSION['username'] = $username;

         $this->SetCookieToUser($token);

     } else {
         return ['invalidRegister' => 'فشل انشاء حساب'];
     }
 }
  public function LogOut(){

    setcookie('remember_token', '', time() - 3600, "/");
    header("Location:/Madad/");
    exit();
 }
 public function isLoggedIn($email, $password)
 {
     if($error = $this->validateEmail($email)){
         return $error;
     }

     if ($error = $this->validatePassword($password)){
         return $error;
     }

     $hashPassword = password_hash(trim($password), PASSWORD_BCRYPT);
    
     if ($this->Model->checkLogin($email, $hashPassword)) {

        $token = $this->Generate4UUID();

        if($this->model->updateToken($token,$email)){

            $this->SetCookieToUser($token);

        }
     } else {
        
         return ['filedLogin' => 'يرجاء انشاء حساب اولاً'];
     }
 }

 public function checkToken($token)
 {
     $getToken = $this->Model->checkToken($token);
    $_SESSION['user_id'] = $getToken['user_id'];
    $_SESSION['username'] = $getToken['username'];
    $_SESSION['email'] = $getToken['email'];
 }
}