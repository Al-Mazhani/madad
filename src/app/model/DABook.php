<?php
include('BaseModel.php');
class DABook   extends BaseModel
{
  public function __construct()
  {
    parent::__construct('books', 'public_id');
  }
  public static function delete($id)
  {
    $QueryDelete = "DELETE FROM books WHERE public_id = :ID";
    $stmt = database::Connection()->prepare($QueryDelete);
    return $stmt->execute(["ID" => $id]);
  }
  public static function ExistsByTitle(string $Title) : bool
  {
    $Query = "SELECT 1 FROM books WHERE  title = :Title limit 1";
    $Stmt = database::Connection()->prepare($Query);
    $Stmt->execute([":Title" => $Title ]);
    return $Stmt->fetchColumn() !== false;
  }
  //  Insert New Book
  public static function insertBook(clsBook $Book): OperationResult
  {
    $QeruyinsertBook = "INSERT INTO books (title,pages,file_type,file_size,image,year,description,author_id,id_category,language,book_url,created_at,public_id)
    VALUES (:name,:pages,:file_type,:file_size,:pathImage,:year,:description,:id_author,:id_category,:language,:pathBook,:created_at,:public_id)";
    $stmt = database::Connection()->prepare($QeruyinsertBook);
    $stmt->execute([
      ":name" => $Book->Title(),
      ":pages" => $Book->Pages(),
      ":file_type" => $Book->FileType(),
      ":file_size" => $Book->FileSize(),
      ":pathImage" => $Book->Image(),
      ":year" => $Book->Year(),
      ":description" => $Book->Description(),
      ":id_author" => $Book->AuthorID(),
      ":id_category" => $Book->CategoryID(),
      ":language" => $Book->Language(),
      ":pathBook" => $Book->BooK(),
      ":created_at" => $Book->CreatedAt(),
      ":public_id" => $Book->PublicID()
    ]);
    return ($stmt->rowCount()) ? OperationResult::Success : OperationResult::Fail;
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
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }
  public function CheckTitleBookExit($title)
  {
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
    return ($stmt->rowCount() > 0)  ? $stmt->fetchAll() : [];
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
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }


  //just Table  Like Book
  public function like(int $IDUser, int $IDBook)
  {
    $queryLike = "INSERT INTO likes_book (id_user,id_book,likes) VALUES (:IDUser,:IDBook,:incrment)";
    $stmt = database::Connection()->prepare($queryLike);
    $stmt->execute(["IDUser" => $IDUser, "IDBook" => $IDBook, "incrment" => 1]);
  }
  // Load Info Book  By ID Book To Show  in Page Dititles book
  public function infoBook(int $PublicID)
  {
    $queryInfoBook = "SELECT * FROM book_info_view where book_public_id  =  :id limit 1";
    $stmt = database::Connection()->prepare($queryInfoBook);
    $stmt->execute(['id' => $PublicID]);
    return ($stmt->rowCount() > 0) ? $stmt->fetch() : [];
  }
  static public function Find(int $PublicID)
  {
    $queryInfoBook = "SELECT * FROM books WHERE public_id = :PublicID LIMIT 1";

    $stmt = database::Connection()->prepare($queryInfoBook);
    $stmt->execute(['PublicID' => $PublicID]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
  }

  // search For Book
  public static function Search(string $Keyword)
  {
    $querSearchForBook = "SELECT * FROM books WHERE title LIKE :Keyword";
    $searchName = "%$Keyword%";
    $stmt = database::Connection()->prepare($querSearchForBook);
    $stmt->execute([":Keyword" => $Keyword]);
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }

  // Increment filed Read Book To Get info how much users Read This Book
  public function incrementReadBook(int $PublicID)
  {
    $queryIncrementReadBook = "UPDATE books SET readBook = COALESCE(readBook,0) + 1 WHERE public_id  = :book_public_id";
    $stmt = database::Connection()->prepare($queryIncrementReadBook);
    return  $stmt->execute([":book_public_id" => $PublicID]);
  }

  // Increment To Know How Much user Download This Book
  public function incrementDonwnload(int $PublicID)
  {
    $queryIncrementDonwnload = "UPDATE books SET downloads = COALESCE(downloads,0) + 1 WHERE public_id = :book_public_id";
    $stmt = database::Connection()->prepare($queryIncrementDonwnload);
    $stmt->execute([":book_public_id" => $PublicID]);
  }
  // Load 15 Books To Show in Page Dititles Section Other Books
  public function LoadOtherBooks()
  {
    $QueryOtherBooks = "SELECT title,book_public_id FROM base_view_book	 limit 15  ";
    $stmt = database::Connection()->prepare($QueryOtherBooks);
    $stmt->execute();
    return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : [];
  }
  public static function Update(clsBook $Book): OperationResult
  {

    $sql = "UPDATE books SET title = :title, author_id = :author_id, year = :year, id_category = :id_category, pages = :pages,
     description = :description, image = :image, file_size = :file_size, language = :language, book_url = :book_url, file_type = :file_type WHERE public_id = :public_id";

    $stmt = database::Connection()->prepare($sql);
    $stmt->execute([
      ':title' => $Book->Title(),
      ':author_id' => $Book->AuthorID(),
      ':year' => $Book->Year(),
      ':id_category' => $Book->CategoryID(),
      ':pages' => $Book->Pages(),
      ':description' => $Book->Description(),
      ':image' => $Book->Image(),
      ':file_size' => $Book->FileSize(),
      ':language' => $Book->Language(),
      ':book_url' => $Book->BooK(),
      ':file_type' => $Book->FileType(),
      ':public_id' => $Book->PublicID()
    ]);
    return ($stmt->rowCount()) ? OperationResult::Updated : OperationResult::Fail;
  }
}
