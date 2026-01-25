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
        $lenghtID = strlen($id);
        if ($lenghtID !== 27) {
            $this->NotAllowDisplayPage();
        }
    }
    // Generate One UUID 3 bit
    protected function GenerateOneUUID($sizeUUID)
    {
        return bin2hex(random_bytes($sizeUUID));
    }
    public function findByID($id)
    {
        $cleanID = $this->validateID($id);
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
    protected function processSearch($search)
    {
        $cleanSearch =  htmlspecialchars($search);
        return $cleanSearch;
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

        return $this->model->search($name);
    }
    protected function CheckFileCacheExists($FileCacheName)
    {

        return (file_exists($FileCacheName)) ? true : false;
    }
    protected function MakeFileCache( $FileCacheName, $data)
    {
        file_put_contents($FileCacheName,json_encode($data));
    }
    protected function GetDataFromFileCahce( $FileCacheName)
    {
        return json_decode(file_get_contents($FileCacheName),true);   
    }
    protected function DeleteFileCache($FileCacheName)
    {
        if($this->CheckFileCacheExists($FileCacheName)){
            unlink($FileCacheName);   
        }
    }
}
