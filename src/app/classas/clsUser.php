<?php
enum enPermissionRole: int
{
   case eAllAccess = -1;
   case eShowAll = 1;
   case eAdd = 2;
   case eDelete = 4;
   case eUpdate = 8;
   case eFind = 16;
};
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
enum enUserInputErrors: int
{
  case  MissinUsername = 1;
  case   LanthUserName = 2;
  case   InvalidUsername = 3;
  case  MissinPassword = 4;
  case  LenghtPassword = 5;
  case   MissinImage = 6;
  case   MissinBackgroundImage = 7;
  case   MissinToken = 8;
  case  InvalidEmail = 9;
  case NoErrors = 10;
};

class clsUser extends clsPerson
{
  private string $_BackgroundImage;
  private enMode $_Mode;
   private int $_Permission;

  // private struct
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
    return new clsUser(enMode::UpdateMode, $User['user_id'], $User['username'], $User['email'], $User['password'], $User['role'],$User['permission'], $User['active_user'], $User['token'], $User['created_at'], $User['image'], $User['background_image']);
  }
  private static function _GetEmptyObject()
  {
    return new clsUser(enMode::EmptyMode, -1, '', '', '', '', false, '', '', '', '',0);
  }
  public function _IsEmpty(): bool
  {
    return ($this->_Mode == enMode::EmptyMode);
  }

  public function __construct(enMode $Mode, int $ID, string $Username, string $Email, string $Password, string $Role,int $Permission, bool $Active, string $Token, string $Created_at, string $Image, string $BackgroundImage)
  {

    parent::__construct($ID, $Username, $Email, $Password, $Role, $Active, $Token, $Created_at, $Image);
    $this->_BackgroundImage = $BackgroundImage;
    $this->_Mode = $Mode;
    $this->_Permission = $Permission;
  }


  public function setBackgroundImage(string $BackgroundImage)
  {
    $this->_BackgroundImage = $BackgroundImage;
  }

  public function BackgroundImage(): string
  {
    return $this->_BackgroundImage;
  }
  public function setPermission(array $Permission): void
  {
    $this->_Permission = $this->_setPermissionRole($Permission);
  }

  public function Permission(): int
  {
    return $this->_Permission;
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

    if (clsUser::IsUserExist($Email)) {

      $User = clsUser::Find($Email);
      $User->setUsername($Username);
      $User->setImage($Image);
      $User->setBackgroundImage($BackgroundImage);
      return clsUser::_Update($User);
    } else {
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
    return new clsUser(enMode::AddMode, 0, '', $Email, '', '', 0,false, '', '', '', '');
  }
  // Delete User
  public  function Delete()
  {
    return  clsUser::_Delete($this->ID());
  }
  public  function Save()
  {
    switch ($this->_Mode) {
      case enMode::EmptyMode: {
          return SaveResult::FailEmptyObject;
          break;
        }
      case enMode::UpdateMode: {
          $HasError = $this->ValidateDateUser();
          if ($HasError === enUserInputErrors::NoErrors) {
            return clsUser::_Update($this);
          } else {
            return $HasError;
          }
          break;
        }
      case enMode::AddMode: {
          $HasError = $this->ValidateDateUser();
          if ($HasError !== enUserInputErrors::NoErrors) {
            return $HasError;
          }
          if (clsUser::IsUserExist($this->Email())) {
            return SaveResult::EmailExists;
          } else {
            return clsUser::_AddUser($this);
          }
          break;
        }
    }
  }


  // Validate Date
  public static function ValidateInputUsername(string $username): enUserInputErrors
  {
    $lenghtUserName =  strlen($username);
    if (empty($username)) {
      return enUserInputErrors::MissinUsername;
    }
    if ($lenghtUserName < 3 || $lenghtUserName > 30) {
      return enUserInputErrors::LanthUserName;
    }
    if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {

      return enUserInputErrors::InvalidUsername;
    }

    return enUserInputErrors::NoErrors;
  }

  public static function validateEmail(string $email): enUserInputErrors
  {

    if (empty($email)) {
      return enUserInputErrors::InvalidEmail;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return enUserInputErrors::InvalidEmail;
    }
    return enUserInputErrors::NoErrors;
  }
  public static function validatePassword(string $password): enUserInputErrors
  {
    $lenghtPassword =  strlen($password);
    if (empty($password)) {
      return enUserInputErrors::MissinPassword;
    }
    if ($lenghtPassword   < 10  || $lenghtPassword > 15) {
      return enUserInputErrors::LenghtPassword;
    }
    return enUserInputErrors::NoErrors;
  }
  private  function ValidateDateUser()
  {
    $ErrorInput = self::ValidateInputUsername($this->Username());

    if ($ErrorInput != enUserInputErrors::NoErrors) {
      return $ErrorInput;
    }
    $ErrorInput = self::validateEmail($this->Email());

    if ($ErrorInput != enUserInputErrors::NoErrors) {
      return $ErrorInput;
    }
    $ErrorInput = self::validatePassword($this->Password());

    if ($ErrorInput != enUserInputErrors::NoErrors) {
      return $ErrorInput;
    }
    return enUserInputErrors::NoErrors;
  }
  //  Permission
  private  function _setPermissionRole(array $arrOfPermission): int
   {
      $TotalOfPermission = 0;

      if (in_array(enPermissionRole::eAllAccess->value, $arrOfPermission)) {
         return -1;
      }
      if (in_array(enPermissionRole::eShowAll->value, $arrOfPermission)) {
         $TotalOfPermission += enPermissionRole::eShowAll->value;
      }
      if (in_array(enPermissionRole::eAdd->value, $arrOfPermission)) {
         $TotalOfPermission += enPermissionRole::eAdd->value;
      }
      if (in_array(enPermissionRole::eDelete->value, $arrOfPermission)) {
         $TotalOfPermission += enPermissionRole::eDelete->value;
      }
      if (in_array(enPermissionRole::eUpdate->value, $arrOfPermission)) {
         $TotalOfPermission += enPermissionRole::eUpdate->value;
      }
      if (in_array(enPermissionRole::eFind->value, $arrOfPermission)) {
         $TotalOfPermission += enPermissionRole::eFind->value;
      }

      return $TotalOfPermission;
   }
   private static function HasPermission(int $userPermission, enPermissionRole $required): bool
   {
      if (enPermissionRole::eAllAccess->value == $userPermission) {
         return true;
      }
      return (($userPermission &  $required->value) ==  $required->value);
   }
   public static function CanShowAll(int $Permission)
   {
      return self::HasPermission($Permission, enPermissionRole::eShowAll);
   }
   public static function CanAdd(int $Permission)
   {
      return self::HasPermission($Permission, enPermissionRole::eAdd);
   }
   public static function CanDelete(int $Permission)
   {
      return self::HasPermission($Permission, enPermissionRole::eDelete);
   }
   public static function CanFind(int $Permission)
   {
      return self::HasPermission($Permission, enPermissionRole::eFind);
   }
   public static function CanUpdate(int $Permission)
   {
      return self::HasPermission($Permission, enPermissionRole::eUpdate);
   }
}
