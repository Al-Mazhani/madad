<?php

class clsAdmin extends clsUser
{

   public function __construct(enMode $Mode, int $ID, string $Username, string $Email, string $Password, string $Role, int $Permission, bool $Active, string $Token, string $Created_at, string $Image, string $BackgroundImage)
   {
      return parent::__construct($Mode, $ID, $Username, $Email, $Password, $Role, $Permission, $Active, $Token, $Created_at, $Image, $BackgroundImage);
   }
   
   
};
