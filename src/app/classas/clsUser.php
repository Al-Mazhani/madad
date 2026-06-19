<?php

class clsUser extends clsPerson
{
  private string $_BackgroundImage;
  private enMode $_Mode;
  private int $_PublicID;
  private int $_Permission;


  private static function _ConvertLineToUserObject(array $User)
  {
    return new clsUser(enMode::UpdateMode, $User['user_id'], $User['PublicID'], $User['username'], $User['email'], $User['password'], enRole::from($User['role']), $User['permission'], UserStatus::from($User['Status']), $User['token'], $User['created_at'], $User['image'], $User['background_image']);
  }
  private static function _GetEmptyObject()
  {
    return new clsUser(enMode::EmptyMode, 0, 0, '', '', '', enRole::None, 0, UserStatus::InActive, '', '', '', '');
  }
  public function IsEmpty(): bool
  {
    return ($this->_Mode == enMode::EmptyMode);
  }

  public function __construct(enMode $Mode, int $ID, int $PublicID, string $Username, string $Email, string $Password, enRole $Role, int $Permission, UserStatus $Status, string $Token, string $Created_at, string $Image, string $BackgroundImage)
  {

    parent::__construct($ID, $Username, $Email, $Password, $Role, $Status, $Token, $Created_at, $Image);
    $this->_BackgroundImage = $BackgroundImage;
    $this->_Mode = $Mode;
    $this->_PublicID = $PublicID;
    $this->_Permission = $Permission;
  }

  public function PublicID(): int
  {
    return $this->_PublicID;
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
    return (!$user->IsEmpty());
  }
  public static function IsUserExistByPublicID(int $PublicID)
  {
    $user = clsUser::FindByPublicID($PublicID);
    return (!$user->IsEmpty());
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


  public  function Update(): bool
  {
    if ($this->CanUpdate()) {
      return ModelUser::Update($this);
    } else {
      return false;
    }
  }
  private function _MakeRandomID()
  {
    return random_int(100000, 999999);
  }

  public static function GetAddNewUser(string $Email)
  {
    return new clsUser(enMode::AddMode, 0, 0, '', $Email, '', enRole::User, 0, UserStatus::Pending, '', '', '', '');
  }
  // Delete User
  public  function Delete(): bool
  {

    if (ModelUser::Delete($this->ID())) {
      $this->_Mode = enMode::EmptyMode;
      return true;
    }
    return false;
  }
  private function _HashingPassword(string $HashingPassword)
  {
    $this->setPassword(
      password_hash($HashingPassword, PASSWORD_DEFAULT)
    );
  }
  // Otp Start:

  private function _CreateOTP()
  {
    $Otp = clsOTP::AddOTP($this->Email());
    return $Otp->Save();
  }
  public function SendAccountVerificationOTP()
  {
    return $this->_CreateOTP();
  }
  public function SendPasswordResetOTP()
  {
    return $this->_CreateOTP();
  }
  public function IsOTPValid(int $Code): bool
  {
    return  clsOTP::VerifyUserCode($Code, $this->ID());
  }
  private function _GenerateToken()
  {
    $this->_Token = $this->_Generate4UUID();
  }
  private function _GeneratePublicID()
  {
    $this->_PublicID = $this->_MakeRandomID();
  }
  private function _PrepareNewUserData()
  {
    $this->_GeneratePublicID();
    $this->_HashingPassword($this->Password());
    $this->_GenerateToken();
  }
  private function _AddNewUser()
  {
    $this->_PrepareNewUserData();
    return ModelUser::AddNewUser($this);
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
    if (in_array(0, $arrOfPermission)) {
      return $TotalOfPermission;
    }
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
  public  function CanDelete()
  {

    return self::_HasPermission($this->Permission(), enPermission::eDelete);
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

  public static function Login(string $Email, string $Password): clsUser | enResultSave
  {
    $UserLoggin = clsUser::FindByEmail(self::CleanEmail($Email));

    if ($UserLoggin->_Mode  == enMode::UpdateMode) {
      if (password_verify(self::CleanPassword($Password), $UserLoggin->Password())) {
        return  $UserLoggin;
      } else {
        return enResultSave::Failed;
      }
    } else {
      return enResultSave::EmptyObject;
    }
  }
  public function ChangePassword(string $NewPassword)
  {

    $this->_HashingPassword($NewPassword);
    return $this->Save();
  }
  // Token
  private function _Generate1UUID(int $sizeUUID)
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
  //  Account Status Management
  public  function Ban()
  {
    $this->setStatus(UserStatus::Banned);
  }
  public function Active()
  {
    $this->setStatus(UserStatus::Active);
  }
  public function Pending()
  {
    $this->setStatus(UserStatus::Pending);
  }
  public function InActive()
  {
    $this->setStatus(UserStatus::InActive);
  }
  public  function Save(): enResultSave
  {
    switch ($this->_Mode) {
      case enMode::EmptyMode: {
          return enResultSave::EmptyObject;
        }
      case enMode::UpdateMode: {
          return ($this->Update()) ? enResultSave::Success : enResultSave::Failed;
        }
      case enMode::AddMode: {
          if (clsUser::IsUserExist($this->Email())) {
            return enResultSave::Exists;
          }
          if ($this->_AddNewUser()) {
            $this->_Mode = enMode::UpdateMode;
            return enResultSave::Success;
          }
          return enResultSave::Failed;
        }
    }
    return enResultSave::Failed;
  }
}
