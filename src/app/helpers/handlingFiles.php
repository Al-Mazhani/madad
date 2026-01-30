<?php
class HandlingFiles
{



    public static function UploadFile($File, $foderPath, $pathDB)
    {
        $newFile = uniqid() . "." . strtolower(pathinfo($File['name'], PATHINFO_EXTENSION));
        $filePathDB = $pathDB . $newFile;
        move_uploaded_file($File['tmp_name'], $foderPath . $newFile);
        return  $filePathDB;
    }
}
