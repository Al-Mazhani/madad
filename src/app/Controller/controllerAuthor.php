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
    $imgName = $image['name'];
    $imgExt  = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($imgExt, $allowed)) {
      return  "خطأ في تحميل  امتداد الصورة";
    }
    return null;
  }
  private function validateAuthor($name, $bio, $image)
  {
    if ($error = $this->validateInputText($name, $bio)) {
      return ['hasInputEmpty' => $error];
    }
    if ($error = $this->validateInputImage($image)) {
      return ['hasFileEmpty' => $error];
    }
    return null;
  }
  private function uploadImage($image)
  {
    $feedBackUploadImage = HandlingFiles::uploadImage($image, __DIR__ . '/../../../uploads/Author_profile/', 'uploads/Author_profile/');
    return $feedBackUploadImage;
  }
  private function ProcessInputsAuhtor($name, $image, $bio, $public_id = null, $oldImage = null)
  {
    $cleanName = trim($name);
    $cleanBio = trim($bio);
    if (empty($public_id)) {
      $public_id = $this->Generate4UUID();
    }
    if ($image['size'] == 0) {
      $pathImage = $oldImage;
    } else {

      $pathImage = $this->uploadImage($image);
    }
    return [
      'public_id' => $public_id,
      'name' => $cleanName,
      'pathImage' => $pathImage,
      'bio' => $cleanBio
    ];
  }

  public function findMoreOne($id)
  {

    return $this->model->loadAllAuthorBook($id);
  }
  public function findByID($id)
  {
    return $this->model->loadInfoAuthorByID($id);
  }


  public function addAuthor($nameAuthor, $imageURLAuthro, $bio)
  {
    if ($error = $this->validateAuthor($nameAuthor, $bio, $imageURLAuthro)) {
      return $error['hasInputEmpty'];
    }
    $public_id = "";
    $data = $this->ProcessInputsAuhtor($nameAuthor, $imageURLAuthro, $bio, $public_id);
    $result = $this->model->insert($data);
    return ($result) ? "تم إضافة المؤلف بنجاح" : "فشل إضافة المؤلف";
  }
  public function search($search)
  {
    $this->validateSearch($search);
    $resultSearch = $this->model->search($search);
    return $resultSearch;
  }
  public function update($public_id, $name, $image, $oldImage, $bio)
  {
    $error = $this->validateAuthor($name, $bio, $image); 
    if(!empty($error) && isset($error['hasInputEmpty'])){
      return $error['hasInputEmpty'];
    }
    
    $cleanData = $this->ProcessInputsAuhtor($name, $image, $bio, $public_id, $oldImage);
    $ResultUpdateAuthor = $this->model->update($cleanData);
    return ($ResultUpdateAuthor) ? ['successUpdate' => 'تم تعديل بيانات المؤلف'] : ['failedUpdate' => 'فشل تعديل بيانات الكتاب'];
  }
}
