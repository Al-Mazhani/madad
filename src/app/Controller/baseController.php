<?php
class BaseController
{


    public $model;
    public function __construct($model)
    {
        $this->model = $model;
    }
    // function To Include File Error URL 

    protected function NotAllowDisplayPage(): void
    {
        include __DIR__ . '/../view/errorURL.php';
        exit();
    }

    // Check IF ID has error
    protected function validateID($id): void
    {
        if (strlen($id) != 6 || !filter_var($id, FILTER_VALIDATE_INT)) {
            $this->NotAllowDisplayPage();
        }
    }
    protected function CleanInputText($Text)
    {
        return trim(strip_tags($Text));
    }
    protected function CleanInputNumber($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
    // Generate One UUID 3 bit
    protected function GenerateOneUUID($sizeUUID)
    {
        return bin2hex(random_bytes($sizeUUID));
    }
    public function findByID($id)
    {
        $this->validateID($id);

        $resutlFindByID = $this->model->findByID($id);

        if (empty($resutlFindByID)) {

            $this->NotAllowDisplayPage();
        }
        return $resutlFindByID;
    }
    // Make 
    protected function Generate4UUID()
    {
        $UUID = "";
        $UUID .= $this->GenerateOneUUID(3) . "-";
        $UUID .= $this->GenerateOneUUID(3) . "-";
        $UUID .= $this->GenerateOneUUID(3) . "-";
        $UUID .= $this->GenerateOneUUID(3);
        return $UUID;
    }
    protected function validateSearch($search)
    {
        if (empty($search)) {
            return false;
        }
        if (strlen($search) <= 2) {
            return false;
        }
        return true;
    }

    public function getAll()
    {
        return $this->model->loadAll();
    }
    public function delete($id)
    {

        $this->validateID($id);
        $resultBookToDelete = $this->findByID($id);

        if ($this->model->delete($id)) {
            $this->deleteFile($resultBookToDelete['image']);
            $this->deleteFile($resultBookToDelete['book_url']);
        }
    }
    public   function search(string $name)
    {


        if (!$this->validateSearch($name)) {
            return ['hasErrorInSearch' => 'البحث غير صالح'];
        }

        return $this->model->search($this->CleanInputText($name));
    }
    // Files 

    protected function CheckFileCacheExists($FileCacheName)
    {

        return (file_exists($FileCacheName)) ? true : false;
    }
    protected function MakeFileCache($FileCacheName, $data)
    {
        file_put_contents($FileCacheName, json_encode($data));
    }
    protected function GetDataFromFileCahce($FileCacheName)
    {
        return json_decode(file_get_contents($FileCacheName), true);
    }
    protected function deleteFile($FileCacheName)
    {
        if ($this->CheckFileCacheExists($FileCacheName)) {
            unlink($FileCacheName);
        }
    }
    private function isMimeTypeAllowed($File, $FileType)
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
    protected function CheckAllowedMimeTypeFile($File, $FileType)
    {
        if (!is_uploaded_file($File['tmp_name'])) {
            return false;
        }


        $imgExt  = strtolower(pathinfo($File['name'], PATHINFO_EXTENSION));
        $allowed = [
            'image' => ['jpg', 'jpeg', 'png', 'webp'],
            'book' =>  ['pdf']
        ];
        return (in_array($imgExt, $allowed[$FileType]) && $this->isMimeTypeAllowed($File, $FileType));
    }

    protected function MakePublicID()
    {
        return random_int(111111, 999999);
    }
}
