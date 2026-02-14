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

        return [];
    }


    private function validateFileInputBook($dataAddBook)
    {

        //Start Part check Book
        if (!isset($dataAddBook['book']) || $dataAddBook['book']['size'] == 0) {

            return ['hasFileEmpty' => 'يرجاء إدخال الكتاب'];
        }

        if (!$this->CheckAllowedExtensionBook($dataAddBook['book'])) {

            return  ['hasFileEmpty' => "خطأ في   امتداد الكتاب "];
        }
        //End Part check Book
        return [];
    }

    private function validateFileInputImage($dataAddBook)
    {

        // Start Part check Image
        if (!isset($dataAddBook['image']) || $dataAddBook['image']['size'] == 0) {
            return ['hasFileEmpty' => 'يرجاء إدخال الصورة'];
        }

        if (!$this->CheckAllowedExtensionImage($dataAddBook['image'])) {

            return  ['hasFileEmpty' => "خطأ في تحميل  امتداد الصورة"];
        }
        return [];
    }
    private function ValidateNumberInputs($dataAddBook)
    {

        if (empty($dataAddBook['id_author']) || !filter_var($dataAddBook['id_author'],FILTER_VALIDATE_INT)) {
            return ['hasInputEmpty' => 'يرجاء تحدد المؤلف'];
        }
        if (empty($dataAddBook['publish_year'])) {
            return ['hasInputEmpty' => 'يرجاء تحديد السنة'];
        }
        if (empty($dataAddBook['id_category']) || !filter_var($dataAddBook['id_category'],FILTER_VALIDATE_INT)) {
            return ['hasInputEmpty' => 'يرجاء تحديد الفئة'];
        }
        if (empty($dataAddBook['pages']) || !filter_var($dataAddBook['pages'], FILTER_VALIDATE_INT)) {
            return ['hasInputEmpty' => 'يرجاءإدخال عدد الصفحات'];
        }
        if ($dataAddBook['pages']  <= 20) {
            return ['hasInputEmpty' => 'ادخل عدد اكبر من 20'];
        }
        return [];
    }
    // private function CheckExitIDAuthorAndCategory($IDs)
    // {
    //     if (!$this->AuthorMolde->checkIDExit($IDs['id_author'])) {
    //         return ['hasInputEmpty' => 'المؤلف ليس موجود'];
    //     }
    //     return [];
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
        $dataAddBook['public_id'] = $this->MakePublicID();

        $dataAddBook['nameBook'] = strtolower($this->CleanInputText($dataAddBook['nameBook']));
        $dataAddBook['description'] = strtolower($this->CleanInputText($dataAddBook['description']));
        $dataAddBook['language'] = strtolower($this->CleanInputText($dataAddBook['language']));

        $dataAddBook['id_author'] = $this->CleanInputText(strtolower($dataAddBook['id_author']));
        $dataAddBook['id_category'] = $this->CleanInputText(strtolower($dataAddBook['id_category']));

        $dataAddBook['pages'] = $this->CleanInputNumber(trim($dataAddBook['pages']));
        $dataAddBook['publish_year'] = $this->CleanInputNumber(trim($dataAddBook['publish_year']));

        $dataAddBook['image'] = $this->uploadImage($dataAddBook['image']);
        $dataAddBook['file_size'] = $dataAddBook['book']['size'] / 1024;
        $dataAddBook['book'] = $this->uploadBook($dataAddBook['book']);
    }
    // Upload Image
    private  function uploadImage(&$image)
    {
        $feedBackUploadImage = HandlingFiles::UploadFile($image, __DIR__ . '/../../../uploads/image_book/', 'uploads/image_book/');
        return $feedBackUploadImage;
    }
    // Upload Book
    private  function uploadBook(&$book)
    {
        return HandlingFiles::UploadFile($book, __DIR__ . '/../../../uploads/book_url/', 'uploads/book_url/');
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
        $resultBookWithAuthor = $this->modelBook->loadBookByAuthorID($this->CleanInputText($id));
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
        if ($errorImage = $this->validateFileInputImage($dataUpdateBook)) {
            return $errorImage;
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

        $dataUpdateBook['file_size'] = $dataUpdateBook['book']['size'] / 1024;
        $dataUpdateBook['book'] = $this->uploadBook($dataUpdateBook['book']);
    }

    //  Check If Come From Server And  No Error
    public function updateBook($id, $dataUpdateBook)
    {

        $hasError = $this->validateUpdateBook($dataUpdateBook);

        if (!isset($hasError['noInputEmpty'])) {
            return $hasError;
        }

        // Check File Is Exit And If The File Not Eixt Process On
        if ($errorImage = $this->checkExitImage($dataUpdateBook)) {
            return $errorImage;
        }


        if ($errorBook = $this->checkExitFileBook($dataUpdateBook)) {
            return $errorBook;
        }



        $resultUpdate =  $this->modelBook->update($id, $dataUpdateBook);
        $FileCacheName = __DIR__ . '/../cache/baseBook.json';
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
        $resultGetBookByCategory = $this->modelBook->loadBookByCateogryID($this->CleanInputText($id));
        if (empty($resultGetBookByCategory)) {
            $this->NotAllowDisplayPage();
        }
        return $resultGetBookByCategory;
    }
    // Get Info Book By ID To Show In Dititles
    public function getInfoBookByID($idBook)
    {
        $this->validateID($idBook);
        $resultInfoBook = $this->modelBook->infoBook($this->CleanInputNumber($idBook));
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

        $this->modelBook->incrementReadBook($this->CleanInputText($id));
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
