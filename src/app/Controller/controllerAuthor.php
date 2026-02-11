<?php
class ControllerAuthor extends BaseController
{
  public $model;
 public function __construct($model)
  {
    $this->model = $model;
    parent::__construct($model);
  }
  private function validateInputText($name, $bio)
  {
    if (empty($name)) {
      return  ['hasFileEmpty' => "يرجاء إدخال اسم المؤلف"];
    }
    if (empty($bio)) {
      return ['hasFileEmpty' => "يرجاء ادخال وصف المؤلف"];
    }
    return null;
  }
  private function validateInputImage($image)
  {
    if ($image['size'] == 0) {
      return  ['hasFileEmpty' => "يرجاء ادخال الصورة"];
    }

    if (!$this->CheckAllowedExtensionImage($image)) {
      return ['hasFileEmpty' => "خطأ في تحميل  امتداد الصورة"];
    }
    return null;
  }
  private function validateAuthor($name, $bio, $image)
  {
    if ($error = $this->validateInputText($name, $bio)) {
      return  $error;
    }
    if ($error = $this->validateInputImage($image)) {
      return $error;
    }
    return [];
  }
  private function uploadImage($image)
  {
    return HandlingFiles::UploadFile($image, __DIR__ . '/../../../uploads/Author_profile/', 'uploads/Author_profile/');
    
  }
  private function ProcessInputsAuhtor($name, $image, $bio, $public_id = null, $oldImage = null)
  {
    $cleanName = trim($name);
    $cleanBio = trim($bio);
    if (empty($public_id)) {
      $public_id = $this->MakePublicID();
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
  // Function To Show Ditels Author
  public function findByID($id)
  {
    $this->validateID($id);
    
    $resultInofAuhtor = $this->model->loadInfoAuthorByID($this->CleanInputText($id));

    if (empty($resultInofAuhtor)){

      $this->NotAllowDisplayPage();

    }
    
    return $resultInofAuhtor;
  }


  public function addAuthor($nameAuthor, $imageURLAuthro, $bio)
  {
    if ($error = $this->validateAuthor($nameAuthor, $bio, $imageURLAuthro)) {
      return $error;
    }
    $public_id = "";
    
    $data = $this->ProcessInputsAuhtor($nameAuthor, $imageURLAuthro, $bio, $public_id);
    
    $result = $this->model->insert($data);
    return ($result) ? [ 'successAdd' => "تم إضافة المؤلف بنجاح" ] : [ 'successFild' =>  "فشل إضافة المؤلف"];
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
