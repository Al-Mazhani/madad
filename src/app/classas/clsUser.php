<?php

class clsUser extends clsPerson{
    private $_BackgroundImage;
  public function __construct(int $ID, string $Username, string $Email, string $Password, int $Role, bool $Active, string $Token, string $Created_at, string $Image,string $BackgroundImage)
  {
    parent::__construct($ID, $Username, $Email, $Password, $Role, $Active, $Token, $Created_at, $Image);
    $this->_BackgroundImage = $BackgroundImage;
  }
    
  public function setBackgroundImage($BackgroundImage)
  {
    $this->_BackgroundImage = $BackgroundImage;
  } 

  public function BackgroundImage()
  {
    return $this->_BackgroundImage;
  } 
}

?>