<?php
class  ModelAdmin 
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    
    }
    
    public function loadAll()
    {
        $query = "SELECT * FROM admins";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
         $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $data;
    }
     function checkLogin($email,$password){
     
       return false;
     }

       public function insert($name, $email, $password)
    {
        $query = "INSERT INTO admins (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);

        return $stmt->execute([$name, $email, $password]);
    }
}
?>