    <?php
    enum enBookError
    {
        case EmptyTitle;
        case EmptyDescription;
        case EmptyLanguage;
        case InvalidAuthor;
        case InvalidCategory;
        case InvalidPages;
        case EmptyPages;
        case EmptyYear;
        case EmptyBookFile;
        case InvalidBookType;
        case BookTooLarge;
        case ImageTooLarge;
        case EmptyImage;
        case InvalidImageType;
        case EmptyFileType;
        case InvalidYear;
        case NoErrors;
    }

    class ClsBookValidation
    {
        private static function isMimeTypeAllowed($File, $FileType)
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $MIME = finfo_file($finfo, $File['tmp_name']);
            finfo_close($finfo);

            $allowed = [
                'image' => ['image/jpeg', 'image/png', 'image/webp'],
                'book' => ['application/pdf']
            ];

            return in_array($MIME, $allowed[$FileType], true);
        }
        private static function CheckAllowedMimeTypeFile($File, $FileType)
        {
            if (!is_uploaded_file($File['tmp_name'])) {
                return false;
            }


            $imgExt  = strtolower(pathinfo($File['name'], PATHINFO_EXTENSION));
            $allowed = [
                'image' => ['jpg', 'jpeg', 'png', 'webp'],
                'book' =>  ['pdf']
            ];
            return (in_array($imgExt, $allowed[$FileType]) && self::isMimeTypeAllowed($File, $FileType));
        }

        public static function validateTextInputs($dataAddBook): enBookError
        {
            if (empty($dataAddBook['bookName'])) {
                return enBookError::EmptyTitle;
            }

            if (empty($dataAddBook['description'])) {
                return enBookError::EmptyDescription;
            }

            if (empty($dataAddBook['language'])) {
                return enBookError::EmptyLanguage;
            }
            if (empty($dataAddBook['file_type'])) {
                return enBookError::EmptyFileType;
            }
            return enBookError::NoErrors;
        }


        public static function validateFileInputBook($dataAddBook): enBookError
        {

            //Start Part check Book
            if (!isset($dataAddBook['book']) || $dataAddBook['book']['size'] == 0) {

                return enBookError::EmptyBookFile;
            }
            if ($dataAddBook['book']['size'] > (8 * 1024 * 1024)) { // Max Size Of File Is 8MB

                return enBookError::BookTooLarge;
            }
            if (!self::CheckAllowedMimeTypeFile($dataAddBook['book'], 'book')) {

                return enBookError::InvalidBookType;
            }
            return enBookError::NoErrors;

            //End Part check Book
        }

        Public static function validateFileInputImage($dataAddBook): enBookError
        {

            // Start Part check Image
            if (!isset($dataAddBook['image']) || $dataAddBook['image']['size'] == 0) {
                return enBookError::EmptyImage;
            }
            if ($dataAddBook['image']['size'] > (8 * 1024 * 1024)) { // Max Size Of File Is 8MB

                   return enBookError::ImageTooLarge;
            }

            if (!self::CheckAllowedMimeTypeFile($dataAddBook['image'], 'image')) {

                return enBookError::InvalidImageType;
            }
            return enBookError::NoErrors;
        }
        private static function ValidateNumberInputs($dataAddBook)
        {

            if (empty($dataAddBook['id_author']) || !filter_var($dataAddBook['id_author'], FILTER_VALIDATE_INT)) {
                return enBookError::InvalidAuthor;
            }
            if (empty($dataAddBook['publish_year'])) {
                return enBookError::EmptyYear;
            }
            if (empty($dataAddBook['id_category']) || !filter_var($dataAddBook['id_category'], FILTER_VALIDATE_INT)) {
                return enBookError::InvalidCategory;
            }
            if (empty($dataAddBook['pages']) || !filter_var($dataAddBook['pages'], FILTER_VALIDATE_INT)) {
                return enBookError::EmptyPages;
            }
            if ($dataAddBook['pages'] <= 20) {
                return enBookError::InvalidPages;
            }
            return enBookError::NoErrors;
        }
        public static function ValidationBook( $BookData,$Files): enBookError
        {
            $ResultText = self::validateTextInputs($BookData);
            if ($ResultText !== enBookError::NoErrors) {
                return $ResultText;
            }
            $ResultBook = self::validateFileInputBook($Files);
            if ($ResultBook !== enBookError::NoErrors) {
                return $ResultBook;
            }
            $ResultImage = self::validateFileInputImage($Files);
            if ($ResultImage !== enBookError::NoErrors) {
                return $ResultImage;
            }
            $ResultNumber = self::ValidateNumberInputs($BookData);
            if ($ResultNumber !== enBookError::NoErrors) {
                return $ResultNumber;
            }
            return enBookError::NoErrors;
        }
    }
