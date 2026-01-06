<?php
include_once 'BaseModel.php';
class ModelAuthor extends BaseModel
{

   public function __construct($database)
  {
    parent::__construct($database, 'authors', 'public_id');
  }


  //  Add Author
  public function insert($nameAuthor, $pathImage, $bio)
  {
    $queryAddAuthor  = "INSERT INTO 	authors (name,image,bio) VALUES (?,?,?)";
    $stmt = $this->database->prepare($queryAddAuthor);
    return $stmt->execute([$nameAuthor, $pathImage, $bio]);
  }

 public function loadInfoAuthorByID($id)
  {
    $stmt = $this->database->prepare("SELECT * FROM view_info_author WHERE public_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function loadAllAuthorBook($id)
  {
    $stmt = $this->database->prepare("SELECT * FROM base_view_book WHERE author_public_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
