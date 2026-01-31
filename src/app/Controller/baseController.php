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
        if (strlen($id) !== 27) {
            $this->NotAllowDisplayPage();
        }
    }
    protected function CleanInputText($Text)
    {
        return trim(strip_tags($Text));
    }
    protected function CleanInputNumber($number)
    {
        return preg_replace('/[^0-9 . ]/', '', $number);
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
        return $this->model->delete($id);
    }
    public   function search(string $name)
    {


        if (!$this->validateSearch($name)) {
            return ['hasErrorInSearch' => 'البحث غير صالح'];
        }

        return $this->model->search($this->CleanInputText($name));
    }
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
    protected function DeleteFileCache($FileCacheName)
    {
        if ($this->CheckFileCacheExists($FileCacheName)) {
            unlink($FileCacheName);
        }
    }
    protected function CheckAllowedExtensionImage($image)
    {

        $imgExt  = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        return (in_array($imgExt, $allowed)) ? true : false;
    }
    protected function CheckAllowedExtensionBook($book)
    {

        $bookExt = strtolower(pathinfo($book['name'], PATHINFO_EXTENSION));
        $allowedExtBook = ["pdf", "zip"];

        return (in_array($bookExt, $allowedExtBook)) ? true : false;
    }
}
