<?php
class  ModelAdmin extends ModelUser
{

    public function __construct()
    {
    }

    public function loadAll()
    {
        $query = "SELECT * FROM users WHERE role = 'admin'";
        $stmt = database::Connection()->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function checkLogin($email)
    {
        $queryLogin = "SELECT * FROM users WHERE email = :email AND role = :role limit 1 ";
        $stmt = database::Connection()->prepare($queryLogin);
        $stmt->execute(["email" => $email,"role" => "admin"]);

        return ($stmt->rowCount()) ? $stmt->fetch() : [];
    }
}
