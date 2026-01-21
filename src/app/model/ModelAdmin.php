<?php
class  ModelAdmin extends ModelUser
{

    public function __construct($database)
    {
        $this->database = $database;
        parent::__construct($database);
    }

    public function loadAll()
    {
        $query = "SELECT * FROM users WHERE role = 'admin'";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function checkLogin($email)
    {
        $queryLogin = "SELECT * FROM users WHERE email = :email AND role = :role limit 1 ";
        $stmt = $this->database->prepare($queryLogin);
        $stmt->execute(["email" => $email,"role" => "admin"]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
