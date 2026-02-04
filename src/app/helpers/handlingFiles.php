<?php
class HandlingFiles
{


    private static function compressionImage($image)
    {
        $quality  = 70;
        $infoImage = getimagesize($image);
        if ($infoImage != true) {
            return false;
        }
        switch ($infoImage['mime']) {

            case 'image/jpeg':

                $imageResource = imagecreatefromjpeg($image);
                imagejpeg($imageResource, $image, $quality);
                return $image;

                break;
            case 'image/webp':

                $imageResource = imagecreatefromwebp($image);
                imagewebp($imageResource, $image, $quality);
                return $image;

                break;
            case 'image/png':

                $imageResource = imagecreatefrompng($image);
                imagepng($imageResource, $image, 7);
                return $image;

                break;
        }
    }
    private static function compressionBook($book)
    {
        $outputFile = dirname($book) . DIRECTORY_SEPARATOR . "compressed_" . basename($book);
        $command = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/ebook -dNOPAUSE -dQUIET -dBATCH -sOutputFile=\"$outputFile tputFile\" \"$book\"";
        shell_exec($command);
        
        if (file_exists($outputFile)) {
            unlink($book);
            rename($outputFile, $book);
        }
        return $book;
    }

    public static function UploadFile($File, $foderPath, $pathDB)
    {
        $FileExtension = strtolower(pathinfo($File['name'], PATHINFO_EXTENSION));
        $newFile = uniqid() . "." . $FileExtension;
        $filePathDB = $pathDB . $newFile;
        move_uploaded_file($File['tmp_name'], $foderPath . $newFile);

        if ($FileExtension == 'pdf') {
            return  self::compressionBook($filePathDB);
        }

        return  self::compressionImage($filePathDB);
    }
}
