<?php

class ControllBook
{
    private $modelBook;
    public function __construct($model)
    {
        $this->modelBook = $model;
    }
    // Check IF ID has error
    private function validateID($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            include __DIR__ . '/../view/errorURL.php';

            exit();
        }
        $cleanID = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if ($cleanID < 0) {
            include __DIR__ . '/../view/errorURL.php';
            exit;
        }
        return $cleanID;
    }
    // If Get ID Integer In Check in Database If Not exists  Not Display  Page. 
    function   NotSDiplayPageWithoutID(): void
    {
        include __DIR__ . '/../view/errorURL.php';
        exit();
    }
    public function getAll()
    {
        $allBooks = $this->modelBook->loadAllBooks();
        return $allBooks;
    }
    function  getInfoBookAndAuthor()
    {
        return $this->modelBook->join_books_authors();
    }
    function getAllCategory()
    {
        return $this->modelBook->loadCategory();
    }
    function getBookAuthor($id)
    {

        $this->validateID($id);
        $resultBookWithAuthor = $this->modelBook->loadBookByAuthorID($id);
        if (empty($resultBookWithAuthor)) {
            $this->NotSDiplayPageWithoutID();
        }
        return $resultBookWithAuthor;
    }
    public function findByID($id)
    {
        $this->validateID($id);
        return $this->modelBook->findOneByid($id);
    }
    public function deleteBook($id)
    {

        $this->validateID($id);
        return $this->modelBook->delete($id);
    }

    //  Check If Come From Server And  No Error
    public function updateBook($id, $bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language, $oldFileSize, $oldBook, $oldImage)
    {
        $hasError =  request::validateCreateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language);
        if (!isset($hasError['hasFileEmpty'])) {
            // return $hasError;
        }

        // Use  Data Book After Prossing
        if ($image['size'] == 0) {
            $pathImage = $oldImage;
        } else {
            $feedBackUploadImage = HandlingFiles::uploadImage($image, __DIR__ . '/../uploads/image_book/', 'uploads/image_book/');
            if (isset($feedBackUploadImage['hasInputEmpty'])) {
                return $feedBackUploadImage;
            } else {
                $pathImage = $feedBackUploadImage['pathImage'];
            }
        }
        if ($book['size'] == 0) {
            $file_size = $oldFileSize;
            $pathBook = $oldBook;
        } else {
            $feedBackUploadBook = HandlingFiles::uploadBook($book, __DIR__ . '/../uploads/book_url/', 'uploads/book_url/');
            if (isset($feedBackUploadBook['hasInputEmpty'])) {
                return  $feedBackUploadBook;
            }
            $file_size = $feedBackUploadBook['file_size'];
            $pathBook = $feedBackUploadBook['PathBook'];
        }
        $resultUpdate =  $this->modelBook->updateBook($id, $bookName, $id_author, $year, $id_category, $pages, $description, $pathImage, $file_size, $file_type, $language, $pathBook);
        return ($resultUpdate) ? ['successUpdate' => 'تم تعديل الكتاب'] : ['failedUpdate' => 'فشل تعديل الكتاب'];
    }


    public function addBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language)
    {
        $hasError = request::validateCreateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language);
        if (!empty($hasError)) {
            return $hasError;
        }
        // Use  Data Book After Prossing 
        $feedBackUploadImage = HandlingFiles::uploadImage($image, __DIR__ . '/../uploads/image_book/', 'uploads/image_book/');
        $feedBackUploadBook = HandlingFiles::uploadBook($book, __DIR__ . '/../uploads/book_url/', 'uploads/book_url/');
        if (isset($feedBackUploadBook['hasInputEmpty'])) {
            return  $feedBackUploadBook;
        }
        if (isset($feedBackUploadImage['hasInputEmpty'])) {
            return $feedBackUploadImage;
        }
        $file_size = $feedBackUploadBook['file_size'];
        $pathBook = $feedBackUploadBook['PathBook'];
        $pathImage = $feedBackUploadImage['pathImage'];
        $result = $this->modelBook->insertBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $file_size, $pathImage, $pathBook, $language);
        if ($result) {
            return ['successAddBook' => 'تم إضافة الكتاب بنجاح'];
        } else {
            return ['NotsuccessAddBook' => 'فشل إضافة الكتاب'];
        }
    }


    public   function search(string $name)
    {

        $validatedSearch  = request::validateSearch($name);
        if ($validatedSearch  === false) {
            return ['hasErrorInSearch' => 'البحث غير صالح'];
        }

        return $this->modelBook->search($name);
    }
    function getBookByCategory($id)
    {
        $this->validateID($id);
        return $this->modelBook->loadBookByCateogryID($id);
    }
    function getInfoBookByID($idBook)
    {
        $this->validateID($idBook);

        $resultInfoBook = $this->modelBook->infoBook($idBook);
        if (empty($resultInfoBook)) {
            $this->NotSDiplayPageWithoutID();
        }
        return $resultInfoBook;
    }
    function like($lik) {}
    function incrementDonwnload($id)
    {
        if (empty($id)) {
            return "فشل في تنزيل الكتاب";
        }
        $resultDownload = $this->modelBook->incrementDonwnload($id);
        return ($resultDownload) ? "تم تنزيل الكتاب" : "فشل في تنزيل الكتاب";
    }
    function incrementReadBook($id)
    {
        $this->modelBook->incrementReadBook($id);
    }
    public function OtherBooks()
    {
        $OtherBooks = $this->modelBook->LoadOtherBooks();
        if (empty($OtherBooks)) {
            return [];
        }
        return $OtherBooks;
    }
}
