<?php

enum enMode: int
{
  case EmptyMode = 0;
  case UpdateMode = 1;
  case AddMode = 2;
  case DeleteMode = 3;
};
enum SaveResult: int
{
  case Fail = 0;
  case Success = 1;
  case EmailExists = 2;
  case Updated = 3;
  case Deleted = 4;
  case FailEmptyObject = 5;
};

class clsUser extends clsPerson
{
  private string $_BackgroundImage;
  private enMode $_Mode;
  private static function _Update(clsUser $User): SaveResult
  {

    $QueryUpdateProfile = "UPDATE users SET username  = :updateName ,image = :image,background_image = :background_image WHERE email = :email";
    $stmt = database::Connection()->prepare($QueryUpdateProfile);
    $stmt->execute([":updateName" => $User->Username(), ":email" => $User->Email(), ":image" => $User->Image(), ":background_image" => $User->BackgroundImage()]);
    return ($stmt->rowCount()) ? SaveResult::Updated : SaveResult::Fail;
  }
  private static function _AddUser(clsUser $User): SaveResult
  {
    $QueryCreateUser = "INSERT INTO users (username,email,password,token,role) VALUES (:username,:email,:password,:token,:role)";
    $stmt = database::Connection()->prepare($QueryCreateUser);
    $stmt->execute([":username" => $User->Username(), ":email" => $User->Email(), ":password" => $User->Password(), ":token" => $User->Toke(), ":role" => $User->Role()]);
    return ($stmt->rowCount()) ? SaveResult::Success : SaveResult::Fail;
  }
  private static function _Delete(int $ID): SaveResult
  {
    $QueryDelete = "DELETE FROM users WHERE user_id  = :ID";
    $stmt = database::Connection()->prepare($QueryDelete);
    $stmt->execute([":ID" => $ID]);
    return ($stmt->rowCount()) ? SaveResult::Deleted : SaveResult::Fail;
  }
  private static function _ConvertLineToUserObject(array $User)
  {
    return new clsUser(enMode::UpdateMode, $User['user_id'], $User['username'], $User['email'], $User['password'], $User['role'], $User['active_user'], $User['token'], $User['created_at'], $User['image'], $User['background_image']);
  }
  private static function _GetEmptyObject()
  {
    return new clsUser(enMode::EmptyMode, -1, '', '', '', '', false, '', '', '', '');
  }
  public function _IsEmpty(): bool
  {
    return ($this->_Mode == enMode::EmptyMode);
  }
  public function __construct(enMode $Mode, int $ID, string $Username, string $Email, string $Password, string $Role, bool $Active, string $Token, string $Created_at, string $Image, string $BackgroundImage)
  {

    parent::__construct($ID, $Username, $Email, $Password, $Role, $Active, $Token, $Created_at, $Image);
    $this->_BackgroundImage = $BackgroundImage;
    $this->_Mode = $Mode;
  }


  public function setBackgroundImage(string $BackgroundImage)
  {
    $this->_BackgroundImage = $BackgroundImage;
  }

  public function BackgroundImage(): string
  {
    return $this->_BackgroundImage;
  }

  public static function Find(string $Email)
  {
    $user = ModelUser::FindByEmail($Email);
    if (!empty($user)) {
      return clsUser::_ConvertLineToUserObject($user);
    } else
      return clsUser::_GetEmptyObject();
  }
  public static function IsUserExist(string $Email)
  {
    $user = clsUser::Find($Email);
    return (!$user->_IsEmpty());
  }


  public static function LoadAllUsers()
  {
    $AllUsers = ModelUser::loadAllUsers();
    $users = [];
    foreach ($AllUsers as $User) {
      array_push($users, clsUser::_ConvertLineToUserObject($User));
    }
    return $users;
  }
  // Update User


  public static function Update(string $Username, string $Email, string $Image, string $BackgroundImage)
  {
    if(clsUser::IsUserExist($Email)){ 

      $User = clsUser::Find($Email);
      $User->setUsername($Username);
      $User->setImage($Image);
      $User->setBackgroundImage($BackgroundImage);
      return clsUser::_Update($User);
      }else{
        return SaveResult::FailEmptyObject; 
      }
  }
  private function _MakeRandomID()
  {
    return random_int(100000, 999999);
  }
  public  function VerifyEmail()
  {
    $Code = $this->_MakeRandomID();
    $Body = '
      <div style="width:25rem;margin:10rem auto;padding:2rem;background-color:#ebebeb;border-radius:0.6rem;box-shadow:0 4px 12px rgba(0,0,0,0.08);text-align:center;">
           <h2 style="color:#2f9e8f;font-size:1.5rem;margin-bottom:0.8rem;">Verify Email</h2>
      <div style="padding:1.5rem;background:#ffffff;border:1px solid #2f9e8f;border-radius:0.6rem;margin-bottom:1.5rem;"><span style="font-weight:bold; font-size:20px;"> ' . $Code . ' </span></div>';
    return $this->SendEmail("hussein.a.al.mazhani@gmail.com", "Verify Email", $Body);
  }

  public static function GetAddNewUser(string $Email)
  {
    return new clsUser(enMode::AddMode, 0, '', $Email, '', '', false, '', '', '', '');
  }
  // Delete User
  public  function Delete()
  {
    return  clsUser::_Delete($this->ID());
  }
  public  function Save()
  {
    switch ($this->_Mode) {
      case enMode::EmptyMode:
        {
          return SaveResult::FailEmptyObject;
        }
          break;
      case enMode::UpdateMode:
        {
          return clsUser::_Update($this);
        }
                  break;
      case enMode::AddMode: {
          if (clsUser::IsUserExist($this->Email())) {
            return SaveResult::EmailExists;
          }
          return clsUser::_AddUser($this);
        }
          break;
    }
  }
}
