<?php
class ControllBook extends BaseController
{
    private $modelBook;
    public function __construct($model)
    {

        $this->modelBook = $model;
        parent::__construct($model);
    }

    private function validateTextInputs($bookName, $description, $language, $file_type)
    {
        if (empty($bookName)) {
            return ['hasInputEmpty' => 'يرجاء كتابة اسم الكتاب'];
        }
        if ($this->modelBook->CheckTitleBookExit($bookName)) {
            return ['hasInputEmpty' => 'الكتاب موجود من قبل'];
        }
        if (empty($description)) {
            return ['hasInputEmpty' => 'يرجاءإدخال وصف الكتاب'];
        }

        if (empty($language)) {
            return ['hasInputEmpty' => 'يرجاء تحدد اللغة'];
        }
        if (empty($file_type)) {
            return ['hasInputEmpty' => 'يرجاء تحدد نوع الملف'];
        }

        return null;
    }
    private function validateFileInputs($image, $book)
    {
        if (!isset($image) || $image['size'] == 0) {
            return ['hasFileEmpty' => 'يرجاء إدخال الصورة'];
        }
        $imgName = $image['name'];
        $imgExt  = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($imgExt, $allowed)) {
            return  ['hasFileEmpty' => "خطأ في تحميل  امتداد الصورة"];
        }
        if (!isset($book) || $book['size'] == 0) {
            return ['hasFileEmpty' => 'يرجاء إدخال الكتاب'];
        }
        return null;
    }
    private function ValidateNumberInputs($id_author, $year, $id_category, $pages)
    {

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
        return null;
    }
    private function  validateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language)
    {
        if ($errorText = $this->validateTextInputs($bookName, $description, $language, $file_type)) {
            return $errorText;
        }

        if ($errorFiles = $this->validateFileInputs($image, $book)) {
            return $errorFiles;
        }
        if ($errorNumeric = $this->ValidateNumberInputs($id_author, $year, $id_category, $pages)) {
            return $errorNumeric;
        }
        return ['noInputEmpty' => true];
    }

    private function processBookData(&$bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language)
    {
        $bookName = strtolower(trim($bookName));
    }
    // Upload Image
    private  function uploadImage($image)
    {
        $feedBackUploadImage = HandlingFiles::uploadImage($image, __DIR__ . '/../../../uploads/image_book/', 'uploads/image_book/');
        return $feedBackUploadImage;
    }
    // Upload Book
    private  function uploadBook($book)
    {
        $feedBackUploadBook = HandlingFiles::uploadBook($book, __DIR__ . '/../../../uploads/book_url/', 'uploads/book_url/');
        return $feedBackUploadBook;
    }

    public function  getInfoBookAndAuthor(&$allBooks)
    {
        $this->modelBook->join_books_authors($allBooks);
    }
    public function getAllCategory()
    {
        return $this->modelBook->loadCategory();
    }
    function loadMoreBooks() {}
    public function getBookAuthor($id)
    {

        $this->validateID($id);
        $resultBookWithAuthor = $this->modelBook->loadBookByAuthorID($id);
        if (empty($resultBookWithAuthor)) {
            $this->NotAllowDisplayPage();
        }
        return $resultBookWithAuthor;
    }


    private function checkExitImage($image, $oldImage)
    {
        // Use  Data Book After Prossing
        if ($image['size'] == 0) {
            return $pathImage = $oldImage;
        }
        $feedBackUploadImage = $this->uploadImage($image);
        return $feedBackUploadImage;
    }
    private function checkExitFileBook($book, $oldBook)
    {
        // Use  Data Book After Prossing
        if ($book['size'] == 0) {
            return  $pathBook = $oldBook;
        }
        $feedBackUploadBook = $this->uploadBook($book);
        return  $feedBackUploadBook;
    }

    //  Check If Come From Server And  No Error
    public function updateBook($id, $bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language, $oldFileSize, $oldBook, $oldImage)
    {
        $hasError =  $this->validateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language);
        if ($hasError != true) {
            return $hasError;
        }

        // Use  Data Book After Prossing
        $feedBackUploadImage = $this->checkExitImage($image, $oldImage);
        if (isset($feedBackUploadImage['hasInputEmpty'])) {
            return $feedBackUploadImage;
        }
        $pathImage = $feedBackUploadImage;

        $feedBackUploadBook = $this->checkExitFileBook($book, $oldBook);
        if (isset($feedBackUploadBook['hasInputEmpty'])) {
            return  $feedBackUploadBook;
        }
        $pathBook = $feedBackUploadBook;
        $file_size = filesize($pathBook);

        $resultUpdate =  $this->modelBook->update($id, $bookName, $id_author, $year, $id_category, $pages, $description, $pathImage, $file_size, $file_type, $language, $pathBook);
        return ($resultUpdate) ? ['successUpdate' => 'تم تعديل الكتاب'] : ['failedUpdate' => 'فشل تعديل الكتاب'];
    }


    public function addBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language)
    {
        $hasError = $this->validateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language);
        if (isset($hasError['hasInputEmpty']) || isset($hasError['hasFileEmpty'])) {
            return $hasError;
        }


        // Upload Image
        $feedBackUploadImage = $this->uploadImage($image);
        // Upload Book
        $feedBackUploadBook = $this->uploadBook($book);
        $pathImage = $feedBackUploadImage;
        $pathBook = $feedBackUploadBook;
        $file_size = filesize($feedBackUploadBook);
        $public_id = $this->Generate4UUID();
        $result = $this->modelBook->insertBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $file_size, $pathImage, $pathBook, $language, $public_id);

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
    public function getBookByCategory($id)
    {
        $this->validateID($id);
        return $this->modelBook->loadBookByCateogryID($id);
    }
    public function getInfoBookByID($idBook)
    {
        $this->validateID($idBook);
        $resultInfoBook = $this->modelBook->infoBook($idBook);
        if (empty($resultInfoBook)) {
            $this->NotAllowDisplayPage();
        }
        return $resultInfoBook;
    }
    public  function like($IDUser, $IDBook)
    {
        $this->modelBook->like($IDUser, $IDBook);
    }
    public function incrementDonwnload($id)
    {
        if (empty($id)) {
            return "فشل في تنزيل الكتاب";
        }
        $resultDownload = $this->modelBook->incrementDonwnload($id);
        return ($resultDownload) ? "تم تنزيل الكتاب" : "فشل في تنزيل الكتاب";
    }
    public function incrementReadBook($id)
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
