<?php
include_once 'BaseModel.php';
class ModelAuthor extends BaseModel
{

  public function __construct()
  {
    parent::__construct( 'authors', 'public_id');
  }


  //  Add Author
  public function insert($cleanData)
  {
    $queryAddAuthor  = "INSERT INTO 	authors (name,image,bio,public_id) VALUES (:name,:image,:bio,:public_id)";
    $stmt = database::Connection()->prepare($queryAddAuthor);
     $stmt->execute([':name' => $cleanData['name'], ':image' => $cleanData['pathImage'], ':bio' => $cleanData['bio'], ':public_id' => $cleanData['public_id']]);
     return ($stmt->rowCount()) ? true : false;
  }

  public function loadInfoAuthorByID($id)
  {
    $stmt = database::Connection()->prepare("SELECT * FROM view_info_author WHERE public_id = ?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0 ?$stmt->fetch(PDO::FETCH_ASSOC) : [];
  }
  public function loadAllAuthorBook($id)
  {
    $stmt = database::Connection()->prepare("SELECT * FROM base_view_book WHERE author_public_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function search($search)
  {
    $QuerySearchAuthor = "SELECT public_id ,name FROM authors WHERE name like :nameAuthor";
    $stmt = database::Connection()->prepare($QuerySearchAuthor);
    $stmt->execute([":nameAuthor" => "%$search%"]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function update($cleanData)
  {
    $QueryUpdateAuhtor = "UPDATE authors set name = :name ,image = :image,bio = :bio WHERE public_id = :public_id";
    $stmt = database::Connection()->prepare($QueryUpdateAuhtor);
    return $stmt->execute([':name' => $cleanData['name'], ':image' => $cleanData['pathImage'], ':bio' => $cleanData['bio'], ':public_id' => $cleanData['public_id']]);
  }
}
