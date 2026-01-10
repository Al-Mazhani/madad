<?php
class HandlingFiles
{


    private function checkExtImage($image){

    }
    public static function uploadImage($image, $foderPath, $pathDB)
    {
        $imgName = $image['name'] ?? null;
        $imgTmp  = $image['tmp_name'] ?? null;
        $imgExt  = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($imgExt, $allowed)) {
            return  ['hasInputEmpty' => "خطأ في تحميل  امتداد الصورة"];
        }

        $newImg = uniqid() . "." . $imgExt;
        $imgPathDB = $pathDB . $newImg;
        move_uploaded_file($imgTmp, $foderPath . $newImg);
        return [ 'pathImage' =>$imgPathDB];
    }
    public static function uploadBook($bookURL, $foderPath, $pathDB)
    {
        $fileName = $bookURL['name'];
        $fileTmp  = $bookURL['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFile = uniqid() . "." . $fileExt;
        $filePathDB = $pathDB . $newFile;
        move_uploaded_file($fileTmp, $foderPath . $newFile);
        return  $filePathDB;
    }
}
