<?php
class HandlingFiles
{


    public static function uploadImage($image, $foderPath, $pathDB)
    {
        $imgName = $image['name'] ?? null;
        $imgTmp  = $image['tmp_name'] ?? null;
        $imgExt  = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        $newImg = uniqid() . "." . $imgExt;
        $imgPathDB = $pathDB . $newImg;
        move_uploaded_file($imgTmp, $foderPath . $newImg);
        return $imgPathDB;
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
