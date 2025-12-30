<?php
include_once 'ControllUser.php';
class controllAdmin extends ControllUser
{

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
        if ($lenghtPassword   < 10 || $lenghtPassword  > 15) {
            return ['lenghtPass' => 'يرجاء املا كلمة المرور  بين 10 و 15 حرف'];
        }
        $hashPassword = Encryption($password);

        if ($this->Model->checkLogin($email, $hashPassword)) {
            header("location:admin/home");
            exit();
        } else {
            return ['filedLogin' => 'انت لست مشرف الموقع'];
        }
    }
}
