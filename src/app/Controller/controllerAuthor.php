<?php
class ControllerAuthor extends BaseController
{
  public $model;
  function __construct($model)
  {
    $this->model = $model;
    parent::__construct($model);
  }
  private function validateInputText($name, $bio)
  {
    if (empty($name)) {
      return "يرجاء إدخال اسم المؤلف";
    }
    if (empty($bio)) {
      return "يرجاء ادخال وصف المؤلف";
    }
    return null;
  }
  private function validateInputImage($image)
  {
    if ($image['size'] == 0) {
      return "يرجاء ادخال الصورة";
    }
    return null;
  }
  private function validateAuthor($public_id, $name, $bio, $image)
  {
    if ($error = $this->validateInputText($name, $bio)) {
      return ['hasInputEmpty' => $error];
    }
    if ($error = $this->validateInputImage($image)) {
      return ['hasInputEmpty' => $error];
    }
    $this->validateID($public_id);
    return null;
  }
  private function uploadImage($image)
  {
    $feedBackUploadImage = HandlingFiles::uploadImage($image, __DIR__ . '/../../../uploads/Author_profile/', 'uploads/Author_profile/');
    return $feedBackUploadImage;
  }
  private function ProcessInputsAuhtor($public_id, $name, $image, $bio)
  {
    $cleanName = trim($name);
    $pathImage = $this->uploadImage($image);
    $cleanBio = trim($bio);
    return [
      'public_id' => $public_id,
      'name' => $cleanName,
      'pathImage' => $pathImage,
      'bio' => $cleanBio
    ];
  }
  public function findByID($id)
  {

    $resultGetAuthorByID = $this->model->loadInfoAuthorByID($id);
    if (empty($resultGetAuthorByID)) {
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

  public function addAuthor($nameAuthor, $imageURLAuthro, $bio)
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
  public function search($search)
  {
    $this->validateSearch($search);
    $resultSearch = $this->model->search($search);
    return $resultSearch;
  }
  public function update($public_id, $name, $image, $bio)
  {
    if ($error = $this->validateAuthor($public_id, $name, $bio, $image)) {
      return $error['hasInputEmpty'];
    }
    $cleanData = $this->ProcessInputsAuhtor($public_id, $name, $image, $bio);
    $ResultUpdateAuthor = $this->model->update($cleanData);
    return ($ResultUpdateAuthor) ? ['successUpdate' => 'تم تعديل بيانات المؤلف'] : ['failedUpdate' => 'فشل تعديل بيانات الكتاب'];
  }
}
