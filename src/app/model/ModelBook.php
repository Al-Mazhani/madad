<?php
include('BaseModel.php');
class ModelBook   extends BaseModel
{
  public function __construct()
  {
    parent::__construct('books', 'public_id');
  }

  //  Insert New Book
  public function insertBook($dataAddBook)
  {
    $QeruyinsertBook = "INSERT INTO books (title,pages,file_type,file_size,image,year,description,author_id,id_category,language,book_url,public_id)
    VALUES (:name,:pages,:file_type,:file_size,:pathImage,:year,:description,:id_author,:id_category,:language,:pathBook,:public_id)";
    $stmt = database::Connection()->prepare($QeruyinsertBook);
    $stmt->execute([
 ":name" => $dataAddBook['nameBook'],
 ":pages" => $dataAddBook['pages'],
 ":file_type" => $dataAddBook['file_type'],
 ":file_size" => $dataAddBook['file_size'],
 ":pathImage" => $dataAddBook['image'],
 ":year" => $dataAddBook['publish_year'],
 ":description" => $dataAddBook['description'],
 ":id_author" => $dataAddBook['id_author'],
 ":id_category" => $dataAddBook['id_category'],
 ":language" => $dataAddBook['language'],
 ":pathBook" => $dataAddBook['book'],
 ":public_id" => $dataAddBook['public_id']
    ]);
    return ($stmt->rowCount()) ? true : false;
  }
  // Load All Books
  public function loadAllBooks()
  {
    $QueryLoadAllBooks = "SELECT * FROM book_info_view ";
    $stmt = database::Connection()->prepare($QueryLoadAllBooks);
    $stmt->execute();
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }


  // Load All Category
  public function  loadCategory()
  {
    $query = "SELECT * FROM category limit 8";
    $stmt = database::Connection()->prepare($query);
    $stmt->execute();
    return  ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }
  public function CheckTitleBookExit($title){
  $QueryExitTitleBook = "SELECT COUNT(*) FROM books WHERE title = :title ";
  $stmt = database::Connection()->prepare($QueryExitTitleBook);
  $stmt->execute([':title' => $title]);
  return $stmt->fetchColumn() > 0;
  }
    // Load This Data To Show In Page Books With Author
  public function join_books_authors()
  {
    $query = "SELECT * FROM base_view_book limit 8  OFFSET 0 ";
    $stmt = database::Connection()->prepare($query);
    $stmt->execute();
    return ($stmt->rowCount() > 0 )  ? $stmt->fetchAll() : [];
  }
  public function loadBookByAuthorID($id)
  {
    $query = "SELECT * FROM base_view_book where author_public_id = :id";
    $stmt = database::Connection()->prepare($query);
    $stmt->execute(['id' => $id]);
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }

  // Load This Category By ID In Page Categroy
  public function loadBookByCateogryID($id)
  {
    $query = "SELECT * FROM base_view_book where category_public_id =:id limit 8";
    $stmt = database::Connection()->prepare($query);
    $stmt->execute([':id' => $id]);
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [] ;
  }


  //just Table  Like Book
  public function like($IDUser, $IDBook)
  {
    $queryLike = "INSERT INTO likes_book (id_user,id_book,likes) VALUES (:IDUser,:IDBook,:incrment)";
    $stmt = database::Connection()->prepare($queryLike);
    $stmt->execute([ "IDUser" => $IDUser, "IDBook" => $IDBook, "incrment" => 1]);
  }
  // Load Info Book  By ID Book To Show  in Page Dititles book
  public function infoBook($idBook)
  {
    $queryInfoBook = "SELECT * FROM book_info_view where book_public_id  =  :id limit 1";
    $stmt = database::Connection()->prepare($queryInfoBook);
    $stmt->execute(['id' => $idBook]);
    return ($stmt->rowCount() > 0 ) ? $stmt->fetch() : [];
  }

  // search For Book
  public function search($search)
  {
    $querSearchForBook = "SELECT * FROM base_view_book WHERE title LIKE :name";
    $searchName = "%$search%";
    $stmt = database::Connection()->prepare($querSearchForBook);
    $stmt->execute([":name" => $searchName]);
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [] ;
  }

  // Increment filed Read Book To Get info how much users Read This Book
  public function incrementReadBook($id)
  {
    $queryIncrementReadBook = "UPDATE books SET readBook = COALESCE(readBook,0) + 1 WHERE public_id  = :book_public_id";
    $stmt = database::Connection()->prepare($queryIncrementReadBook);
    return  $stmt->execute([":book_public_id" => $id]);
  }

  // Increment To Know How Much user Download This Book
  public function incrementDonwnload($id)
  {
    $queryIncrementDonwnload = "UPDATE books SET downloads = COALESCE(downloads,0) + 1 WHERE public_id = :book_public_id";
    $stmt = database::Connection()->prepare($queryIncrementDonwnload);
    $stmt->execute([":book_public_id" => $id]);
  }
  // Load 15 Books To Show in Page Dititles Section Other Books
  public function LoadOtherBooks()
  {
    $QueryOtherBooks = "SELECT title,book_public_id FROM base_view_book	 limit 15  ";
    $stmt = database::Connection()->prepare($QueryOtherBooks);
    $stmt->execute();
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [] ;
  }
  public function update($id,$dataUpdateBook)
  {

    $sql = "UPDATE books SET title = :title, author_id = :author_id, year = :year, id_category = :id_category, pages = :pages,
     description = :description, image = :image, file_size = :file_size, language = :language, book_url = :book_url, file_type = :file_type WHERE public_id = :public_id";

    $stmt = database::Connection()->prepare($sql);
    $stmt->execute([
      ':title' => $dataUpdateBook['nameBook'],
      ':author_id' => $dataUpdateBook['id_author'],
      ':year' => $dataUpdateBook['publish_year'],
      ':id_category' => $dataUpdateBook['id_category'],
      ':pages' => $dataUpdateBook['pages'],
      ':description' => $dataUpdateBook['description'],
      ':image' => $dataUpdateBook['image'],
      ':file_size' => $dataUpdateBook['file_size'], 
      ':language' => $dataUpdateBook['language'],
      ':book_url' => $dataUpdateBook['book'],
      ':file_type' => $dataUpdateBook['file_type'],
      ':public_id' => $id
    ]);
    return ($stmt->rowCount()) ? true : false;
  }

}
