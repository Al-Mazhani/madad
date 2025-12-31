<?php
include_once 'BaseModel.php';
class ModelAuthor extends BaseModel
{

  function __construct($database)
  {
    parent::__construct($database, 'authors', 'id_author');
  }


  //  Add Author
  function insert($nameAuthor, $pathImage, $bio)
  {
    $queryAddAuthor  = "INSERT INTO 	authors (name,image,bio) VALUES (?,?,?)";
    $stmt = $this->database->prepare($queryAddAuthor);
    return $stmt->execute([$nameAuthor, $pathImage, $bio]);
  }

  function loadInfoAuthorByID($id)
  {
    $stmt = $this->database->prepare("SELECT * FROM authors WHERE id_author = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  function loadAllAuthorBook($id)
  {
    $stmt = $this->database->prepare("SELECT * FROM view_books_authors WHERE id_author = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
