<?php
include_once 'BaseModel.php';
class ModelAuthor extends BaseModel
{

  public function __construct($database)
  {
    parent::__construct($database, 'authors', 'public_id');
  }


  //  Add Author
  public function insert($cleanData)
  {
    $queryAddAuthor  = "INSERT INTO 	authors (name,image,bio,public_id) VALUES (:name,:image,:bio,:public_id)";
    $stmt = $this->database->prepare($queryAddAuthor);
    return $stmt->execute([':name' => $cleanData['name'], ':image' => $cleanData['pathImage'], ':bio' => $cleanData['bio'], ':public_id' => $cleanData['public_id']]);
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
  public function search($search)
  {
    $QuerySearchAuthor = "SELECT public_id ,name FROM authors WHERE name like :nameAuthor";
    $stmt = $this->database->prepare($QuerySearchAuthor);
    $stmt->execute([":nameAuthor" => "%$search%"]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function update($cleanData)
  {
    $QueryUpdateAuhtor = "UPDATE authors set name = :name ,image = :image,bio = :bio WHERE public_id = :public_id";
    $stmt = $this->database->prepare($QueryUpdateAuhtor);
    return $stmt->execute([':name' => $cleanData['name'], ':image' => $cleanData['pathImage'], ':bio' => $cleanData['bio'], ':public_id' => $cleanData['public_id']]);
  }
}
