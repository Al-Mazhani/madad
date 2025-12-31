<?php
include('BaseModel.php');
class ModelBook   extends BaseModel
{
  public function __construct($database,)
  {
    parent::__construct($database, 'books', 'id_book');
  }

  //  Insert New Book
  function insertBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $file_size, $imgPathDB, $filePathDB, $language)
  {
    $QeruyinsertBook = "INSERT INTO books (title,pages,file_type,file_size,image,year,description,author_id,id_category,language,book_url)
    VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ";
    $stmt = $this->database->prepare($QeruyinsertBook);
    return $stmt->execute([$bookName, $pages, $file_type, $file_size, $imgPathDB, $year, $description, $id_author, $id_category, $language, $filePathDB]);
  }
  // Load All Books
  function loadAllBooks()
  {
    $QueryLoadAllBooks = "SELECT * FROM view_book order by id_book desc	";
    $stmt = $this->database->prepare($QueryLoadAllBooks);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  // Load All Category
  function  loadCategory()
  {
    $query = "SELECT * FROM category";
    $stmt = $this->database->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Load This Data To Show In Page Books With Author
  public function join_books_authors()
  {
    $query = "SELECT * FROM viewBookWithuthor";
    $stmt = $this->database->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function loadBookByAuthorID($id)
  {
    $query = "SELECT * FROM viewBookWithuthor where id_author = :id";
    $stmt = $this->database->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Load This Category By ID In Page Categroy
  public function loadBookByCateogryID($id)
  {
    $query = "SELECT * FROM view_book_category_by_ID where id_category =:id";
    $stmt = $this->database->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);;
    // $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  //just Table  Like Book
  function like($idUser, $idBook)
  {
    $queryLike = "INSERT INTO likes_book (id_user,id_book,likes) VALUES (???)";
    $stmt = $this->database->prepare($queryLike);
    $stmt->execute([$idUser, $idBook, 1]);
  }
  // Load Info Book  By ID Book To Show  in Page Dititles book
  function infoBook($idBook)
  {
    $queryInfoBook = "SELECT * FROM view_info_book where id_book =  :id";
    $stmt = $this->database->prepare($queryInfoBook);
    $stmt->bindParam(':id', $idBook, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // search For Book
  function search($search)
  {
    $querSearchForBook = "SELECT * FROM viewBookWithuthor WHERE title LIKE :name";
    $searchName = "%$search%";
    $stmt = $this->database->prepare($querSearchForBook);
    $stmt->bindParam(":name", $searchName, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Increment filed Read Book To Get info how much users Read This Book
  function incrementReadBook($id)
  {
    $queryIncrementReadBook = "UPDATE books SET readBook = COALESCE(readBook,0) + 1 WHERE id_book  = ?";
    $stmt = $this->database->prepare($queryIncrementReadBook);
    $stmt->execute([$id]);
  }

  // Increment To Know How Much user Download This Book
  function incrementDonwnload($id)
  {
    $queryIncrementDonwnload = "UPDATE books SET downloads = COALESCE(downloads,0) + 1 WHERE id_book = ?";
    $stmt = $this->database->prepare($queryIncrementDonwnload);
    $stmt->execute([$id]);
  }
  // Load 15 Books To Show in Page Dititles Section Other Books
  function LoadOtherBooks()
  {
    $QueryOtherBooks = "SELECT title,id FROM viewBookWithuthor	 limit 15  ";
    $stmt = $this->database->prepare($QueryOtherBooks);
    // $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function updateBook($id, $bookName, $id_author, $year, $id_category, $pages, $description, $pathImage, $file_size, $file_type, $language, $pathBook)
  {
    $QueryUpdateBook = "UPDATE books SET title = ? , author_id = ?, year = ? , id_category = ? ,
     pages = ? ,description = ? , image = ? ,file_size = ? , language = ? ,book_url = ? , file_type = ?
     WHERE id_book = ?;
     ";
    $stmt = $this->database->prepare($QueryUpdateBook);
    return $stmt->execute([$bookName, $id_author, $year, $id_category, $pages, $description, $pathImage, $file_size, $language, $pathBook, $file_type, $id]);
  }
}
