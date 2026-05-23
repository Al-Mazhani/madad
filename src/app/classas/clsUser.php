<?php
enum UserStatus: int
{
  case InActive = 0;
  case Active = 1;
  case Pending = 2;
  case Banned = 3;
};
enum enPermission: int
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
};
enum OperationResult: int
{
  case Fail = 0;
  case Success = 1;
  case EmailExists = 2;
  case Updated = 3;
  case Deleted = 4;
  case FailEmptyObject = 5;
  case NoPermissions = 6;
  case FailOTP = 7;
};
enum enUserInputErrors: int
{
  case  MissinUsername = 1;
  case   LanthUserName = 2;
  case   InvalidUsername = 3;
  case  MissinPassword = 4;
  case  LengthPassword = 5;
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
  private int $_PublicID;
  private int $_Permission;

  // private struct

  private static function _ConvertLineToUserObject(array $User)
  {
    return new clsUser(enMode::UpdateMode, $User['user_id'], $User['PublicID'], $User['username'], $User['email'], $User['password'], $User['role'], $User['permission'], $User['Status'], $User['token'], $User['created_at'], $User['image'], $User['background_image']);
  }
  private static function _GetEmptyObject()
  {
    return new clsUser(enMode::EmptyMode, -1, 0, '', '', '', '', 0, 0, '', '', '', '');
  }
  public function _IsEmpty(): bool
  {
    return ($this->_Mode == enMode::EmptyMode);
  }

  public function __construct(enMode $Mode, int $ID, int $PublicID, string $Username, string $Email, string $Password, string $Role, int $Permission, int $Status, string $Token, string $Created_at, string $Image, string $BackgroundImage)
  {

    parent::__construct($ID, $Username, $Email, $Password, $Role, $Status, $Token, $Created_at, $Image);
    $this->_BackgroundImage = $BackgroundImage;
    $this->_Mode = $Mode;
    $this->_PublicID = $PublicID;
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
  public static function FindByEmail(string $Email)
  {
    $user = ModelUser::FindByEmail($Email);
    if (!empty($user)) {
      return clsUser::_ConvertLineToUserObject($user);
    } else
      return clsUser::_GetEmptyObject();
  }
  public static function FindByPublicID(int $ID)
  {
    $User = ModelUser::FindByPublicID($ID);
    if (!empty($User)) {
      return clsUser::_ConvertLineToUserObject($User);
    } else
      return clsUser::_GetEmptyObject();
  }
  public static function FindByUsername(string $Username)
  {
    $User = ModelUser::findByUsername($Username);
    if (!empty($User)) {
      return clsUser::_ConvertLineToUserObject($User);
    } else
      return clsUser::_GetEmptyObject();
  }
  public static function IsUserExist(string $Email)
  {
    $user = clsUser::FindByEmail($Email);
    return (!$user->_IsEmpty());
  }
  public static function IsUserExistByPublicID(int $PublicID)
  {
    $user = clsUser::FindByPublicID($PublicID);
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


  public  function Update(): OperationResult
  {
    if ($this->CanUpdate()) {
      return ModelUser::Update($this);
    } else {
      return OperationResult::NoPermissions;
    }
  }
  private function _MakeRandomID()
  {
    return random_int(100000, 999999);
  }

  public static function GetAddNewUser(string $Email)
  {
    return new clsUser(enMode::AddMode, 0, 0, '', $Email, '', '', 0, false, '', '', '', '');
  }
  // Delete User
  public  function Delete(int $Permission): OperationResult
  {

    if (clsUser::CanDelete($Permission)) {
      return (ModelUser::Delete($this->ID())  === OperationResult::Deleted) ? OperationResult::Deleted : OperationResult::Fail;
    } else {
      return OperationResult::NoPermissions;
    }
  }
  private function _HashingPassword(string $HashingPassword)
  {
    $this->setPassword(
      password_hash($HashingPassword, PASSWORD_DEFAULT)
    );
  }
  // Otp Start:


  private function _AddNewUser()
  {
    if (clsUser::IsUserExist($this->Email())) {
      return OperationResult::EmailExists;
    }

    $this->_HashingPassword($this->Password());
    $this->setToken($this->_Generate4UUID());

    return ModelUser::AddUser($this);
  }
  public  function Save()
  {
    switch ($this->_Mode) {
      case enMode::EmptyMode: {
          return OperationResult::FailEmptyObject;
          break;
        }
      case enMode::UpdateMode: {
          return $this->Update();
          break;
        }
      case enMode::AddMode: {
          return $this->_AddNewUser();
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
    if (empty($password)) {
      return enUserInputErrors::MissinPassword;
    }
    $LengthPassword =  strlen($password);
    if ($LengthPassword   < 10  || $LengthPassword > 15) {
      return enUserInputErrors::LengthPassword;
    }
    return enUserInputErrors::NoErrors;
  }
  public  function ValidateDataUser()
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

    if (in_array(enPermission::eAllAccess->value, $arrOfPermission)) {
      return enPermission::eAllAccess->value;
    }
    if (in_array(enPermission::eShowAll->value, $arrOfPermission)) {
      $TotalOfPermission += enPermission::eShowAll->value;
    }
    if (in_array(enPermission::eAdd->value, $arrOfPermission)) {
      $TotalOfPermission += enPermission::eAdd->value;
    }
    if (in_array(enPermission::eDelete->value, $arrOfPermission)) {
      $TotalOfPermission += enPermission::eDelete->value;
    }
    if (in_array(enPermission::eUpdate->value, $arrOfPermission)) {
      $TotalOfPermission += enPermission::eUpdate->value;
    }
    if (in_array(enPermission::eFind->value, $arrOfPermission)) {
      $TotalOfPermission += enPermission::eFind->value;
    }

    return $TotalOfPermission;
  }
  private static function _HasPermission(int $userPermission, enPermission $required): bool
  {
    if (enPermission::eAllAccess->value == $userPermission) {
      return true;
    }
    return (($userPermission &  $required->value) ==  $required->value);
  }
  public  function CanShowAll()
  {
    return self::_HasPermission($this->Permission(), enPermission::eShowAll);
  }
  public  function CanAdd()
  {
    return self::_HasPermission($this->Permission(), enPermission::eAdd);
  }
  static public  function CanDelete(int $Permission)
  {
    // if ($this->ID() === $this->ID()) {
    //   return false;
    // }
    return self::_HasPermission($Permission, enPermission::eDelete);
  }
  public  function CanFind()
  {
    return self::_HasPermission($this->Permission(), enPermission::eFind);
  }
  public  function CanUpdate()
  {
    return self::_HasPermission($this->Permission(), enPermission::eUpdate);
  }

  //  Authentication

  public static function Login(string $Email, string $Password): clsUser | OperationResult
  {
    $UserLoggin = clsUser::FindByEmail(self::CleanEmail($Email));

    if ($UserLoggin->_Mode  == enMode::UpdateMode) {
      if (password_verify(self::CleanPassword($Password), $UserLoggin->Password())) {
        return  $UserLoggin;
      } else {
        return OperationResult::Fail;
      }
    } else {
      return OperationResult::FailEmptyObject;
    }
  }
  public function ChangePassword(string $NewPassword)
  {

    $this->_HashingPassword($NewPassword);
    return $this->Save();
  }
  // Token
  private function _Generate1UUID($sizeUUID)
  {
    return bin2hex(random_bytes($sizeUUID));
  }
  private function _Generate4UUID()
  {
    $UUID = "";
    $UUID .= $this->_Generate1UUID(3) . "-";
    $UUID .= $this->_Generate1UUID(3) . "-";
    $UUID .= $this->_Generate1UUID(3) . "-";
    $UUID .= $this->_Generate1UUID(3);
    return $UUID;
  }
  // private function _SendWelcomeEmail()
  // {
  //   $Body = '
  //     <div style="width:25rem;margin:10rem auto;padding:2rem;background-color:#ebebeb;border-radius:0.6rem;box-shadow:0 4px 12px rgba(0,0,0,0.08);text-align:center;">
  //         <h2 style="color:#2f9e8f;font-size:1.5rem;margin-bottom:0.8rem;">Welcome: ' . $this->Username() . ' ,You can start webing with Madad URL:<a href="http://localhost/Madad/">Madad.com</a> </h2> 
  //     </div>';
  //   return $this->SendEmail("hussein.a.al.mazhani@gmail.com", 'Welcome: ' . $this->UserName(), $Body);
  // }
}
