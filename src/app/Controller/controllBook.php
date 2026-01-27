<?php
class ControllBook extends BaseController
{
    private $modelBook;
    public function __construct($model)
    {

        $this->modelBook = $model;
        parent::__construct($model);
    }

    private function validateTextInputs($dataAddBook)
    {
        if (empty($dataAddBook['nameBook'])) {
            return ['hasInputEmpty' => 'يرجاء كتابة اسم الكتاب'];
        }

        if (empty($dataAddBook['description'])) {
            return ['hasInputEmpty' => 'يرجاءإدخال وصف الكتاب'];
        }

        if (empty($dataAddBook['language'])) {
            return ['hasInputEmpty' => 'يرجاء تحدد اللغة'];
        }
        if (empty($dataAddBook['file_type'])) {
            return ['hasInputEmpty' => 'يرجاء تحدد نوع الملف'];
        }

        return null;
    }
    private function validateFileInputBook($dataAddBook)
    {

        //End Part check Image
        //Start Part check Book
        if (!isset($dataAddBook['book']) || $dataAddBook['book']['size'] == 0) {

            return ['hasFileEmpty' => 'يرجاء إدخال الكتاب'];
        }

        $bookName = $dataAddBook['book']['name'];

        $bookExt = strtolower(pathinfo($bookName, PATHINFO_EXTENSION));

        $allowedExtBook = ["pdf", "zip"];

        if (!in_array($bookExt, $allowedExtBook)) {

            return  ['hasFileEmpty' => "خطأ في   امتداد الكتاب "];
        }
        //End Part check Book
        return null;
    }
    private function validateFileInputImage($dataAddBook)
    {

        // Start Part check Image
        if (!isset($dataAddBook['image']) || $dataAddBook['image']['size'] == 0) {
            return ['hasFileEmpty' => 'يرجاء إدخال الصورة'];
        }

        $imgName = $dataAddBook['image']['name'];

        $imgExt  = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($imgExt, $allowed)) {

            return  ['hasFileEmpty' => "خطأ في تحميل  امتداد الصورة"];
        }
    }
    private function ValidateNumberInputs($dataAddBook)
    {

        if (empty($dataAddBook['id_author']) || !filter_var($dataAddBook['id_author'], FILTER_VALIDATE_INT)) {
            return ['hasInputEmpty' => 'يرجاء تحدد المؤلف'];
        }
        if (empty($dataAddBook['publish_year'])) {
            return ['hasInputEmpty' => 'يرجاء تحديد السنة'];
        }
        if (!filter_var($dataAddBook['id_category'], FILTER_VALIDATE_INT) || empty($dataAddBook['id_category'])) {
            return ['hasInputEmpty' => 'يرجاء تحديد الفئة'];
        }
        if (empty($dataAddBook['pages']) || !filter_var($dataAddBook['pages'], FILTER_VALIDATE_INT)) {
            return ['hasInputEmpty' => 'يرجاءإدخال عدد الصفحات'];
        }
        if ($dataAddBook['pages']  <= 20) {
            return ['hasInputEmpty' => 'ادخل عدد اكبر من 20'];
        }
        return null;
    }
    // private function CheckExitIDAuthorAndCategory($IDs)
    // {
    //     if (!$this->AuthorMolde->checkIDExit($IDs['id_author'])) {
    //         return ['hasInputEmpty' => 'المؤلف ليس موجود'];
    //     }
    //     return null;
    // }
    private function  validateBook(&$dataAddBook)
    {
        if ($errorText = $this->validateTextInputs($dataAddBook)) {
            return $errorText;
        }
        if ($this->modelBook->CheckTitleBookExit($dataAddBook['nameBook'])) {
            return ['hasInputEmpty' => 'الكتاب موجود من قبل'];
        }

        if ($errorFiles = $this->validateFileInputBook($dataAddBook)) {
            return $errorFiles;
        }
        if ($errorFiles = $this->validateFileInputImage($dataAddBook)) {
            return $errorFiles;
        }
        if ($errorNumeric = $this->ValidateNumberInputs($dataAddBook)) {
            return $errorNumeric;
        }
        // if ($errorNumeric = $this->CheckExitIDAuthorAndCategory($dataAddBook)) {
        //     return $errorNumeric;
        // }
        return ['noInputEmpty' => true];
    }
    private function validateUpdateBook($dataUpdateBook)
    {

        if ($errorText = $this->validateTextInputs($dataUpdateBook)) {
            return $errorText;
        }
        if ($errorNumeric = $this->ValidateNumberInputs($dataUpdateBook)) {
            return $errorNumeric;
        }
        // if ($errorNumeric = $this->CheckExitIDAuthorAndCategory($dataUpdateBook)) {
        //     return $errorNumeric;
        // }
        return ['noInputEmpty' => true];
    }

    private function processBookData(&$dataAddBook)
    {
        $dataAddBook['public_id'] = $this->Generate4UUID();

        $dataAddBook['nameBook'] = strtolower(trim($dataAddBook['nameBook']));
        $dataAddBook['description'] = strtolower(trim($dataAddBook['description']));
        $dataAddBook['language'] = strtolower(trim($dataAddBook['language']));

        $dataAddBook['id_author'] = filter_var(strtolower(trim($dataAddBook['id_author'])), FILTER_SANITIZE_NUMBER_INT);
        $dataAddBook['id_category'] = filter_var(strtolower(trim($dataAddBook['id_category'])), FILTER_SANITIZE_NUMBER_INT);
        $dataAddBook['pages'] = filter_var(strtolower(trim($dataAddBook['pages'])), FILTER_SANITIZE_NUMBER_INT);

        $dataAddBook['image'] = $this->uploadImage($dataAddBook['image']);
        $dataAddBook['file_size'] = filesize($dataAddBook['book']['tmp_name']) / 1024;
        $dataAddBook['book'] = $this->uploadBook($dataAddBook['book']);
    }
    // Upload Image
    private  function uploadImage(&$image)
    {
        $feedBackUploadImage = HandlingFiles::uploadImage($image, __DIR__ . '/../../../uploads/image_book/', 'uploads/image_book/');
        return $feedBackUploadImage;
    }
    // Upload Book
    private  function uploadBook(&$book)
    {
        $feedBackUploadBook = HandlingFiles::uploadBook($book, __DIR__ . '/../../../uploads/book_url/', 'uploads/book_url/');
        return $feedBackUploadBook;
    }

    public function  getInfoBookAndAuthor()
    {
        $FileCacheName =  __DIR__ . '/../cache/' . "baseBook.json";
        if ($this->CheckFileCacheExists($FileCacheName)) {
            return $this->GetDataFromFileCahce($FileCacheName);
        } else {
            $dataBaseBook = $this->modelBook->join_books_authors();
            $this->MakeFileCache($FileCacheName, $dataBaseBook);
            return $dataBaseBook;
        }
    }
    public function getAllCategory()
    {
        return $this->modelBook->loadCategory();
    }
    public function loadMoreBooks() {}
    public function getBookAuthor($id)
    {

        $this->validateID($id);
        $resultBookWithAuthor = $this->modelBook->loadBookByAuthorID($id);
        if (empty($resultBookWithAuthor)) {
            $this->NotAllowDisplayPage();
        }
        return $resultBookWithAuthor;
    }


    private function checkExitImage(&$dataUpdateBook)
    {
        // Use  Data Book After Prossing
        if ($dataUpdateBook['image']['size'] == 0) {
            $dataUpdateBook['image'] = $dataUpdateBook['oldPathImage'];
            $dataUpdateBook['file_size'] = $dataUpdateBook['oldFileSize'];
            return;
        }
        if ($error = $this->validateFileInputImage($dataUpdateBook)) {
            return $error;
        } else {
            $dataUpdateBook['image'] = $this->uploadImage($dataUpdateBook['image']);
        }
    }
    private function checkExitFileBook(&$dataUpdateBook)
    {
        // Use  Data Book After Prossing
        if ($dataUpdateBook['book']['size'] == 0) {
            $dataUpdateBook['book'] = $dataUpdateBook['oldFileBook'];
            $dataUpdateBook['file_size'] = $dataUpdateBook['oldFileSize'];
            return;
        }

        if ($error = $this->validateFileInputBook($dataUpdateBook)) {
            return $error;
        }

        $book = $dataUpdateBook['book'];
        $dataUpdateBook['file_size'] = filesize($book) / 1024;
        $dataUpdateBook['book'] = $this->uploadBook($dataUpdateBook['book']);
    }

    //  Check If Come From Server And  No Error
    public function updateBook($id, $dataUpdateBook)
    {
        $hasError =  $this->validateUpdateBook($dataUpdateBook);
        if (!isset($hasError['hasInputEmpty'])) {
            return $hasError;
        }

        // Use  Data Book After Prossing
        if ($error = $this->checkExitImage($dataUpdateBook)) {
            return $error;
        }


        if ($error = $this->checkExitFileBook($dataUpdateBook)) {
            return $error;
        }


        $resultUpdate =  $this->modelBook->update($id, $dataUpdateBook);
        $FileCacheName = __DIR__ . '/../cache/' . "baseBook.json";
        $this->DeleteFileCache($FileCacheName);
        return ($resultUpdate) ? ['successUpdate' => 'تم تعديل الكتاب'] : ['failedUpdate' => 'فشل تعديل الكتاب'];
    }


    public function addBook($dataAddBook)
    {
        $hasError = $this->validateBook($dataAddBook);
        if (isset($hasError['hasInputEmpty']) || isset($hasError['hasFileEmpty'])) {
            return $hasError;
        }

        $this->processBookData($dataAddBook);

        $result = $this->modelBook->insertBook($dataAddBook);

        $FileCacheName = __DIR__ . '/../cache/' . "baseBook.json";
        $this->DeleteFileCache($FileCacheName);

        return ($result) ? ['successAddBook' => 'تم إضافة الكتاب بنجاح'] :  ['NotsuccessAddBook' => 'فشل إضافة الكتاب'];
    }


    // Get Book By Category To Display in Page Categorys
    public function getBookByCategory($id)
    {
        $this->validateID($id);
        $resultGetBookByCategory = $this->modelBook->loadBookByCateogryID($id);
        if (empty($resultGetBookByCategory)) {
            $this->NotAllowDisplayPage();
        }
        return $resultGetBookByCategory;
    }
    // Get Info Book By ID To Show In Dititles
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
