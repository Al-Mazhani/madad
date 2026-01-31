<?php
include_once('BaseModel.php');

class ModelUser extends BaseModel
{
    protected $database;
    public function __construct()
    {
        parent::__construct("users", 'user_id');
    }

    public function checkLogin($email)
    {
        $queryLogin = "SELECT * FROM users WHERE email = :email AND role = :User LIMIT 1";
        $stmt = database::Connection()->prepare($queryLogin);
        $stmt->execute([":email" => $email, ":User" => 'user']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return false;
        }
        return $result;
    }
    public function update($username, $email) {
        $QueryUpdateProfile = "UPDATE users SET username = :updateName WHERE email = :email";
        $stmt = database::Connection()->prepare($QueryUpdateProfile);
        $stmt->execute(["updateName" => $username, "email" => $email]);
       return ($stmt->rowCount()) ? true : false;
    }
    public function checkToken($token)
    {
        $queryToken = "SELECT * FROM users WHERE token = :Token";
        $stmt = database::Connection()->prepare($queryToken);
        $stmt->execute(["Token" => $token]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return false;
        }
        return $result;
    }
    public function CheckEmailExit($email){
        $QueryCheckEmailExit = "SELECT email FROM users WHERE email = :email";
        $stmt = database::Connection()->prepare($QueryCheckEmailExit);
        $stmt->execute(['email' => $email]);
        return ($stmt->rowCount() > 0) ? $stmt->fetch() : [];

    }
   public function updateToken($newToken, $email)
    {
        $queryUpdateToken = "UPDATE users SET token = :newToken WHERE email = :email";
        $stmt = database::Connection()->prepare($queryUpdateToken);
        $stmt->execute([':newToken' => $newToken,':email' => $email]);
        return ($stmt->rowCount()) ? true : false;
    }
   public function insert($username, $email, $password, $token,$role)
    {
        $QueryCreateUser = "INSERT INTO users (username,email,password,token,role) VALUES (:username,:email,:password,:token,:role)";
        $stmt = database::Connection()->prepare($QueryCreateUser);
        $stmt->execute([":username" => $username,":email" => $email, ":password" => $password, ":token" => $token,":role" => $role]);
        return ($stmt->rowCount()) ? true : false;
    }
}
