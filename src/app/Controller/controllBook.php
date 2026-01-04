<?php
class ControllBook extends BaseController
{
    private $modelBook;
    public function __construct($model)
    {
        $this->modelBook = $model;
    }
    private function  validateCreateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language)
    {
        if (empty($bookName)) {
            return ['hasInputEmpty' => 'يرجاء كتابة اسم الكتاب'];
        }
        if (empty($id_author)) {
            return ['hasInputEmpty' => 'يرجاء تحدد المؤلف'];
        }
        if (empty($year)) {
            return ['hasInputEmpty' => 'يرجاء تحديد السنة'];
        }
        if (!filter_var($id_category, FILTER_VALIDATE_INT)) {
            return ['hasInputEmpty' => 'يرجاء تحديد الفئة'];
        }
        if (empty($pages)) {
            return ['hasInputEmpty' => 'يرجاءإدخال عدد الصفحات'];
        }
        if ($pages  <= 20) {
            return ['hasInputEmpty' => 'ادخل عدد اكبر من 20'];
        }
        if (empty($file_type)) {
            return ['hasInputEmpty' => 'يرجاء تحدد نوع الملف'];
        }
        if (empty($description)) {
            return ['hasInputEmpty' => 'يرجاءإدخال وصف الكتاب'];
        }
        if (!isset($image) || $image['size'] == 0) {
            return ['hasFileEmpty' => 'يرجاء إدخال الصورة'];
        }

        if (empty($language)) {
            return ['hasInputEmpty' => 'يرجاء تحدد اللغة'];
        }
        if (!isset($book) || $book['size'] == 0) {
            return ['hasFileEmpty' => 'يرجاء إدخال الكتاب'];
        }
        return null;
    }
    private function processBookData(&$bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language)
    {
        $bookName = strtolower(trim($bookName));
        
    }
    private  function uploadImage($image)
    {
        $feedBackUploadImage = HandlingFiles::uploadImage($image, __DIR__ . '/../../../uploads/image_book/', 'uploads/image_book/');
        return $feedBackUploadImage;
    }
    private  function uploadBook($book)
    {
        $feedBackUploadBook = HandlingFiles::uploadBook($book, __DIR__ . '/../../../uploads/book_url/', 'uploads/book_url/');
        return $feedBackUploadBook;
    }
    public function getAll()
    {
        $allBooks = $this->modelBook->loadAllBooks();
        return $allBooks;
    }
    public function  getInfoBookAndAuthor()
    {
        return $this->modelBook->join_books_authors();
    }
    public function getAllCategory()
    {
        return $this->modelBook->loadCategory();
    }
    public function getBookAuthor($id)
    {

        $cleanID = $this->validateID($id);
        $resultBookWithAuthor = $this->modelBook->loadBookByAuthorID($cleanID);
        if (empty($resultBookWithAuthor)) {
            $this->NotAllowDisplayPage();
        }
        return $resultBookWithAuthor;
    }
    public function findByID($id)
    {
       $cleanID = $this->validateID($id);
        $resutlFindByID = $this->modelBook->findOneByid($cleanID);
        if (empty($resutlFindByID)) {
            $this->NotAllowDisplayPage();
        }
        return $resutlFindByID;
    }
    public function deleteBook($id)
    {

         $cleanID  = $this->validateID($id);
        return $this->modelBook->delete($cleanID);
    }

    //  Check If Come From Server And  No Error
    public function updateBook($id, $bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language, $oldFileSize, $oldBook, $oldImage)
    {
        $hasError =  $this->validateCreateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language);
        if (!isset($hasError['hasFileEmpty'])) {
            return $hasError;
        }

        // Use  Data Book After Prossing
        if ($image['size'] == 0) {
            $pathImage = $oldImage;
        } else {
            $feedBackUploadImage = $this->uploadImage($image);
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
            $feedBackUploadBook = $this->uploadBook($book);
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
        $hasError = $this->validateCreateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language);
        if (!empty($hasError)) {
            return $hasError;
        }

        // Upload Image
        $feedBackUploadImage = $this->uploadImage($image);
        // Upload Book
        $feedBackUploadBook = $this->uploadBook($book);
        if (isset($feedBackUploadBook['hasInputEmpty'])) {
            return  $feedBackUploadBook;
        }

        $pathImage = $feedBackUploadImage['pathImage'];

        if (isset($feedBackUploadImage['hasInputEmpty'])) {
            return $feedBackUploadImage;
        }

        $file_size = $feedBackUploadBook['file_size'];
        $pathBook = $feedBackUploadBook['PathBook'];
        $public_id = $this->Generate4UUID();
        $result = $this->modelBook->insertBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $file_size, $pathImage, $pathBook, $language);
        
        return ($result) ? ['successAddBook' => 'تم إضافة الكتاب بنجاح'] :  ['NotsuccessAddBook' => 'فشل إضافة الكتاب'];
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
            $this->NotAllowDisplayPage();
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
