<?php
include_once 'BaseModel.php';
class ModelAuthor extends BaseModel
{

  public function __construct()
  {
    parent::__construct('authors', 'public_id');
  }
  public static function ExistsByName(string $Name): bool
  {
    $Query = "SELECT 1 FROM authors WHERE name = :name LIMIT 1";
    $stmt = database::Connection()->prepare($Query);
    $stmt->execute([":name" => $Name]);
    return (bool) $stmt->fetchColumn();
  }

  public function checkIDExit($id)
  {
    $QueryFindAuthorByID = "SELECT id_author FROM authors WHERE id_author = :id";
    $stmt = database::Connection()->prepare($QueryFindAuthorByID);
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount();
  }
  public static function FindByName(string $Name)
  {
    $QueryFind = "SELECT * FROM authors  WHERE name = :name ";
    $stmt = database::Connection()->prepare($QueryFind);
    $stmt->execute([":name" => $Name]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  //  Add Author
  public static function Insert(clsAuthor $Author): OperationResult
  {
    $queryAddAuthor  = "INSERT INTO 	authors (name,image,bio,public_id,created_at,Gender,BirthDate,Nationality) VALUES (:name,:image,:bio,:public_id,:created_at,:Gender,:BirthDate,:Nationality)";
    $stmt = database::Connection()->prepare($queryAddAuthor);
    $stmt->execute(
      [':name' => $Author->Name(),
       ':image' => $Author->Image(),
        ':bio' => $Author->Bio(),
         ':public_id' => $Author->PublicID(),
          ":created_at" => $Author->CreatedAt(),
          ":Gender" => $Author->Gender()->value,
          ":BirthDate" => $Author->BirthDate(),
          ":Nationality" => $Author->Nationality()->value]);
    return ($stmt->rowCount()) ? OperationResult::Success : OperationResult::Fail;
  }

  public function loadInfoAuthorByID($id)
  {
    $stmt = database::Connection()->prepare("SELECT * FROM view_info_author WHERE public_id = ?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : [];
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
  public static function Update(clsAuthor $Author) : OperationResult
  {
    $QueryUpdateAuhtor = "UPDATE authors set name = :name ,image = :image,bio = :bio WHERE public_id = :public_id";
    $stmt = database::Connection()->prepare($QueryUpdateAuhtor);
    $stmt->execute([':name' => $Author->Name(), ':image' => $Author->Image(), ':bio' => $Author->Bio(), ':public_id' => $Author->PublicID()]);
    return ($stmt->rowCount()) ? OperationResult::Updated : OperationResult::Fail;
  }
}
