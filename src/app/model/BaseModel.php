<?php
class BaseModel
{
    protected $database;
    protected $table;
    protected $primaryKey;
    function  __construct($database, $table, $primaryKey)
    {
        $this->database = $database;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }
    public function loadAll()
    {
        $query = "SELECT * FROM $this->table order by $this->primaryKey limit 20";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $QueryDelete = "DELETE FROM $this->table WHERE $this->primaryKey = :ID";
        $stmt = $this->database->prepare($QueryDelete);
        return $stmt->execute(["ID" => $id]);
    }
    public  function findByID($id)
    {
        $QueryFind = "SELECT * FROM $this->table  WHERE $this->primaryKey = ?";
        $stmt = $this->database->prepare($QueryFind);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function checkIDExit($IDExit) {
        $QueryCheckIDExit = "SELECT * FROM $this->table  WHERE $this->primaryKey = :Public_id";
        $stmt = $this->database->prepare($QueryCheckIDExit);
        $stmt->execute([':Public_id' => $IDExit]);
        $stmt->fetch();
        $ExitID = $stmt->rowCount();
        return ($ExitID) ? true : false;
    }
}
