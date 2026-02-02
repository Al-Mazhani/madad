<?php
class BaseModel
{
    protected $database;
    protected $table;
    protected $primaryKey;
   public function  __construct( $table, $primaryKey)
    {
    
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }
    public function loadAll()
    {
        $query = "SELECT * FROM $this->table order by $this->primaryKey limit 20";
        $stmt = database::Connection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $QueryDelete = "DELETE FROM $this->table WHERE $this->primaryKey = :ID";
        $stmt = database::Connection()->prepare($QueryDelete);
        return $stmt->execute(["ID" => $id]);
    }
    public  function findByID($id)
    {
        $QueryFind = "SELECT * FROM $this->table  WHERE $this->primaryKey = ?";
        $stmt = database::Connection()->prepare($QueryFind);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function checkIDExit($IDExit) {
        $QueryCheckIDExit = "SELECT * FROM $this->table  WHERE $this->primaryKey = :Public_id";
        $stmt = database::Connection()->prepare($QueryCheckIDExit);
        $stmt->execute([':Public_id' => $IDExit]);
        $stmt->fetch();
        $ExitID = $stmt->rowCount();
        return ($ExitID) ? true : false;
    }
}
