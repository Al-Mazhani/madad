<?php
include_once('BaseModel.php');

class ModelUser extends BaseModel
{
    protected $database;
    public function __construct()
    {
        parent::__construct("users", 'user_id');
    }
    public static function FindByPublicID(int $ID)
    {
        $QueryFind = "SELECT * FROM users  WHERE user_id = :ID";
        $stmt = database::Connection()->prepare($QueryFind);
        $stmt->execute([":ID" => $ID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findByUsername(string $Username)
    {
        $QueryFind = "SELECT * FROM users  WHERE username = :Username";
        $stmt = database::Connection()->prepare($QueryFind);
        $stmt->execute([":Username" => $Username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function Update(clsUser $User): OperationResult
    {

        $QueryUpdateProfile = "UPDATE users SET username  = :Username ,image = :image,background_image = :background_image,password = :password,email = :email,token = :Token,role = :Role,Status = :Status,created_at = :CreatedAt ,permission = :permission WHERE user_id = :user_id";
        $stmt = database::Connection()->prepare($QueryUpdateProfile);
        $stmt->execute([":Username" => $User->Username(), ":email" => $User->Email(), ":image" => $User->Image(), ":background_image" => $User->BackgroundImage(), ":password" => $User->Password(), ":Token" => $User->Token(), ":Role" => $User->Role(), ":Status" => $User->Status(), ":CreatedAt" => $User->Created_at(), ":permission" => $User->Permission(), ":user_id" => $User->ID()]);
        return OperationResult::Updated;
    }
    public static function AddUser(clsUser $User): OperationResult
    {
        $QueryCreateUser = "INSERT INTO users (username,email,password,token,role) VALUES (:username,:email,:password,:token,:role)";
        $stmt = database::Connection()->prepare($QueryCreateUser);
        $ResultAddUser = $stmt->execute([":username" => $User->Username(), ":email" => $User->Email(), ":password" => $User->Password(), ":token" => $User->Token(), ":role" => $User->Role()]);
        return ($ResultAddUser) ? OperationResult::Success : OperationResult::Fail;
    }
    public static function Delete(int $ID): OperationResult
    {
        $QueryDelete = "DELETE FROM users WHERE user_id  = :ID";
        $stmt = database::Connection()->prepare($QueryDelete);
        $stmt->execute([":ID" => $ID]);
        return ($stmt->rowCount()) ? OperationResult::Deleted : OperationResult::Fail;
    }
    static function loadAllUsers()
    {
        $query = "SELECT * FROM users ";
        $stmt = database::Connection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function FindByEmail($email)
    {
        $queryLogin = "SELECT * FROM users WHERE email = :email";
        $stmt = database::Connection()->prepare($queryLogin);
        $stmt->execute([":email" => $email]);
        return  $stmt->fetch(PDO::FETCH_ASSOC);
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
    public function CheckEmailExit($email)
    {
        $QueryCheckEmailExit = "SELECT email FROM users WHERE email = :email";
        $stmt = database::Connection()->prepare($QueryCheckEmailExit);
        $stmt->execute(['email' => $email]);
        return ($stmt->rowCount() > 0) ? $stmt->fetch() : [];
    }
    public function updateToken($newToken, $email)
    {
        $queryUpdateToken = "UPDATE users SET token = :newToken WHERE email = :email";
        $stmt = database::Connection()->prepare($queryUpdateToken);
        $stmt->execute([':newToken' => $newToken, ':email' => $email]);
        return ($stmt->rowCount()) ? true : false;
    }
    public static function insert(clsUser $User) {}
    public function changePassword(&$newPassword, &$email)
    {
        $QueryChangePassword = "UPDATE users SET password = :newPassword WHERE email = :email";
        $stmt = database::Connection()->prepare($QueryChangePassword);
        $stmt->execute([':newPassword' => $newPassword, ':email' => $email]);
        return $stmt->rowCount() ? true : false;
    }
}
