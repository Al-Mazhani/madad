<?php
include_once('BaseModel.php');

class ModelUser extends BaseModel
{
    protected $database;
    function __construct($database)
    {
        parent::__construct($database, "users", 'user_id');
    }

    public function checkLogin($email, $password)
    {
        $queryLogin = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->database->prepare($queryLogin);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return false;
        }
        return $result;
    }
    public function update($username, $email) {}
    function checkToken($token)
    {
        $queryToken = "SELECT * FROM users WHERE token = ?";
        $stmt = $this->database->prepare($queryToken);
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return false;
        }
        return $result;
    }
   public function updateToken($newToken, $email)
    {
        $queryUpdateToken = "UPDATE users SET token = ? WHERE email = ?";
    }
   public function insert($username, $email, $password, $token,$role)
    {
        $QueryCreateUser = "INSERT INTO users (username,email,password,token,role) VALUES (:username,:email,:password,:token,:role)";
        $stmt = $this->database->prepare($QueryCreateUser);
        return $stmt->execute([":username" => $username,":email" => $email, ":password" => $password, ":token" => $token,":role" => $role]);
    }
}
