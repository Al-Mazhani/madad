<?php
class ControllerAuthor extends BaseController
{
  private $model;
  function __construct($model)
  {
    $this->model = $model;
  }
  public function findOneByid($id)
  {

    $this->validateID($id);
    $resultGetAuthorByID = $this->model->loadInfoAuthorByID($id);
    if(empty($resultGetAuthorByID)){
      $this->NotAllowDisplayPage();
    }
    return $resultGetAuthorByID;
  }
  public function findMoreOne($id)
  {

    return $this->model->loadAllAuthorBook($id);
  }
  public function getAll()
  {
    return $this->model->loadAll();
  }
  function addAuthor($nameAuthor, $imageURLAuthro, $bio)
  {
    if (empty($nameAuthor)) {
      return "يرجاء إدخال الاسم";
    }
    if (empty($bio)) {
      return "يرجاء إدخال وصف المؤلف";
    }
    $feedbeekUploadImage = HandlingFiles::uploadImage($imageURLAuthro, __DIR__ . '/../../../uploads/Author_profile/', 'uploads/Author_profile/');
    if (isset($feedbeekUploadImage['hasInputEmpty'])) {
      return   $feedbeekUploadImage;
    }
    $pathImage =  $feedbeekUploadImage['pathImage'];
    $result = $this->model->insert($nameAuthor, $pathImage, $bio);
    return ($result) ? "تم إضافة المؤلف بنجاح" : "فشل إضافة المؤلف";
  }
}
