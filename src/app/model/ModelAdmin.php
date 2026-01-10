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
        $query = "SELECT * FROM admins";
        $stmt = $this->database->prepare($query);
        // $stmt->execute();
         $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $data;
    }
     function checkLogin($email,$password){
     
       return false;
     }

 
}
?>