<?php
class ControllerAuthor
{
  private $model;
  function __construct($model)
  {
    $this->model = $model;
  }
  public function findOneByid($id)
  {

    return $this->model->loadInfoAuthorByID($id);
  }
  public function findMoreOne($id)
  {

    return $this->model->loadAllAuthorBook($id,);
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
    $nameImage = $imageURLAuthro['name'];
    $imageTmp = $imageURLAuthro['tmp_name'];
    $imgExt = strtolower(pathinfo($nameImage, PATHINFO_EXTENSION));
    $allowed =  ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($imgExt, $allowed)) {
      return "خطأ في تحميل الصورة";
    }
    $NewNameImage = uniqid() . "." . $imgExt;
    $imgFolder = __DIR__ . '/../uploads/Author_profile/';
    $pathImage = 'uploads/Author_profile/' . $NewNameImage;
    move_uploaded_file($imageTmp, $imgFolder . $NewNameImage);
    $result = $this->model->insert($nameAuthor, $pathImage, $bio);
    return ($result) ? "تم إضافة المؤلف بنجاح" : "فشل إضافة المؤلف";
  }
  
}
