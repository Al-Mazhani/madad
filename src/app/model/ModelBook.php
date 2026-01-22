<?php
include('BaseModel.php');
class ModelBook   extends BaseModel
{
  public function __construct($database,)
  {
    parent::__construct($database, 'books', 'public_id');
  }

  //  Insert New Book
  public function insertBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $file_size, $imgPathDB, $filePathDB, $language, $public_id)
  {
    $QeruyinsertBook = "INSERT INTO books (title,pages,file_type,file_size,image,year,description,author_id,id_category,language,book_url,public_id)
    VALUES (:name,:pages,:file_type,:file_size,:pathImage,:year,:description,:id_author,:id_category,:language,:pathBook,:public_id)";
    $stmt = $this->database->prepare($QeruyinsertBook);
    $stmt->execute([
      ":name" => $bookName,
      ":pages" => $pages,
      ":file_type" => $file_type,
      ":file_size" => $file_size,
      ":pathImage" => $imgPathDB,
      ":year" => $year,
      ":description" => $description,
      ":id_author" => $id_author,
      ":id_category" => $id_category,
      ":language" => $language,
      ":pathBook" => $filePathDB,
      ":public_id" => $public_id
    ]);
    return ($stmt->rowCount()) ? true : false;
  }
  // Load All Books
  public function loadAllBooks()
  {
    $QueryLoadAllBooks = "SELECT * FROM book_info_view ";
    $stmt = $this->database->prepare($QueryLoadAllBooks);
    $stmt->execute();
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }


  // Load All Category
  public function  loadCategory()
  {
    $query = "SELECT * FROM category limit 8";
    $stmt = $this->database->prepare($query);
    $stmt->execute();
    return  ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }
  public function CheckTitleBookExit($title){
  $QueryExitTitleBook = "SELECT COUNT(*) FROM books WHERE title = :title ";
  $stmt = $this->database->prepare($QueryExitTitleBook);
  $stmt->execute([':title' => $title]);
  return $stmt->fetchColumn() > 0;
  }
    // Load This Data To Show In Page Books With Author
  public function join_books_authors(&$allBooks)
  {
    $query = "SELECT * FROM base_view_book limit 8  OFFSET 0 ";
    $stmt = $this->database->prepare($query);
    $stmt->execute();
    $allBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function loadBookByAuthorID($id)
  {
    $query = "SELECT * FROM base_view_book where author_public_id = :id";
    $stmt = $this->database->prepare($query);
    $stmt->execute(['id' => $id]);
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }

  // Load This Category By ID In Page Categroy
  public function loadBookByCateogryID($id)
  {
    $query = "SELECT * FROM base_view_book where category_public_id =:id limit 8";
    $stmt = $this->database->prepare($query);
    $stmt->execute([':id' => $id]);
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [] ;
  }


  //just Table  Like Book
  public function like($IDUser, $IDBook)
  {
    $queryLike = "INSERT INTO likes_book (id_user,id_book,likes) VALUES (:IDUser,:IDBook,:incrment)";
    $stmt = $this->database->prepare($queryLike);
    $stmt->execute([ "IDUser" => $IDUser, "IDBook" => $IDBook, "incrment" => 1]);
  }
  // Load Info Book  By ID Book To Show  in Page Dititles book
  function infoBook($idBook)
  {
    $queryInfoBook = "SELECT * FROM book_info_view where book_public_id  =  :id";
    $stmt = $this->database->prepare($queryInfoBook);
    $stmt->bindParam(':id', $idBook, PDO::PARAM_INT);
    $stmt->execute();
    return ($stmt->rowCount() > 0 ) ? $stmt->fetch() : [];
  }

  // search For Book
  public function search($search)
  {
    $querSearchForBook = "SELECT * FROM base_view_book WHERE title LIKE :name";
    $searchName = "%$search%";
    $stmt = $this->database->prepare($querSearchForBook);
    $stmt->bindParam(":name", $searchName, PDO::PARAM_STR);
    $stmt->execute();
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [] ;
  }

  // Increment filed Read Book To Get info how much users Read This Book
  public function incrementReadBook($id)
  {
    $queryIncrementReadBook = "UPDATE books SET readBook = COALESCE(readBook,0) + 1 WHERE public_id  = :book_public_id";
    $stmt = $this->database->prepare($queryIncrementReadBook);
    return  $stmt->execute([":book_public_id" => $id]);
  }

  // Increment To Know How Much user Download This Book
  function incrementDonwnload($id)
  {
    $queryIncrementDonwnload = "UPDATE books SET downloads = COALESCE(downloads,0) + 1 WHERE public_id = :book_public_id";
    $stmt = $this->database->prepare($queryIncrementDonwnload);
    $stmt->execute([":book_public_id" => $id]);
  }
  // Load 15 Books To Show in Page Dititles Section Other Books
  public function LoadOtherBooks()
  {
    $QueryOtherBooks = "SELECT title,book_public_id FROM base_view_book	 limit 15  ";
    $stmt = $this->database->prepare($QueryOtherBooks);
    $stmt->execute();
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [] ;
  }
  public function update($id, $bookName, $id_author, $year, $id_category, $pages, $description, $pathImage, $file_size, $file_type, $language, $pathBook)
  {
    $sql = "UPDATE books SET title = :title, author_id = :author_id, year = :year, id_category = :id_category, pages = :pages,
     description = :description, image = :image, file_size = :file_size, language = :language, book_url = :book_url, file_type = :file_type WHERE public_id = :public_id";

    $stmt = $this->database->prepare($sql);

    $stmt->execute([
      ':title' => $bookName,
      ':author_id' => $id_author,
      ':year' => $year,
      ':id_category' => $id_category,
      ':pages' => $pages,
      ':description' => $description,
      ':image' => $pathImage,
      ':file_size' => $file_size,
      ':language' => $language,
      ':book_url' => $pathBook,
      ':file_type' => $file_type,
      ':public_id' => $id
    ]);
    return ($stmt->rowCount()) ? true : false;
  }
}
