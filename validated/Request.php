<?php
class request
{
    public  static function  validateCreateBook($bookName, $id_author, $year, $id_category, $pages, $description, $file_type, $image, $book, $language)
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
        if (!filter_var($id_category,FILTER_VALIDATE_INT)) {
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
    public static function validateSearch($search)
    {
        $searchRequst = trim($search);
        if ($searchRequst == '') {
            return false;
        }
        $langhtSearch = mb_strlen($search, 'UTF-8');
        if (!($langhtSearch >= 1 || $langhtSearch <= 30)) {
            return false;
        }
        if (!preg_match('/^[\p{L}\p{N}\s]+$/u', $search)) {
            return false;
        }
        return true;
    }

}
