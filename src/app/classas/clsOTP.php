<?php
class clsOTP
{
private int $_ID;
private int $_Code;
private enMode $_Mode;
private string $_EmailUser;
private int $_UserID;
private DateTime $_ExpirationTime;
public function __construct(enMode $Mode, int $ID, string $EmailUser, int $Code, int $UserID, string $ExpirationTime)
{
    $this->_ID = $ID;
    $this->_Mode = $Mode;
    $this->_EmailUser = $EmailUser;
    $this->_Code = $Code;
    $this->_UserID  = $UserID;
    $this->_ExpirationTime  = new DateTime($ExpirationTime);
}
public function GetCode(): int
{
    return $this->_Code;
}
public function GetUserID(): int
{
    return $this->_UserID;
}
public function SetExpirationTime(string $ExpirationTime): void
{
    $this->_ExpirationTime = new DateTime($ExpirationTime);
}
public function GetExpirationTime(): DateTime
{
    return $this->_ExpirationTime;
}
private static  function _EmptyObject()
{
    return new clsOTP(enMode::EmptyMode, 0, "", 0, 0, "");
}
public static function AddOTP(string $Email)
{
    return new clsOTP(enMode::AddMode, 0, $Email, 0, 0, "");
}
private static function _ConvertDBOTPToObject(array $DateOTP)
{
    return new clsOTP(enMode::UpdateMode, $DateOTP['ID'], "", $DateOTP['Code'], $DateOTP['userID'], $DateOTP['ExpirationTime']);
}
private function _SetUpOTP()
{
    $this->_Code = random_int(100000, 999999);
    $this->_ExpirationTime = new DateTime('+5 minutes');
}
public  function IsExpired(): bool
{
    return (new DateTime() > $this->_ExpirationTime);
}
public function IsEmpty(): bool
{
    return ($this->_Mode === enMode::EmptyMode);
}
private function _CreateOTPRow(clsOTP $NewOTP): bool
{
    $Query = "INSERT INTO opts (Code, UserID, ExpirationTime)VALUES (:Code,:UserID,:ExpirationTime)";
    $stmt = database::Connection()->prepare($Query);
    return $stmt->execute([":Code" => $this->_Code, ":UserID" => $this->_UserID, ":ExpirationTime" => $this->_ExpirationTime->format('Y-m-d H:i:s')]);
}
private function _AddNewOTP()
{
    if (!$this->_GetUserInfo()) {
        return OperationResult::FailOTP;
    }
    $this->_SetUpOTP();
    if ($this->_CreateOTPRow($this) === OperationResult::Fail) {
        return OperationResult::FailOTP;
    }
    if ($this->_SendEmailToUser() === enSendEmail::Success) {
        return OperationResult::Success;
    }
    return OperationResult::FailOTP;
}
private function _GetUserInfo()
{
    $User = clsUser::FindByEmail($this->_EmailUser);
    if (!$User->IsEmpty()) {
        $this->_UserID = $User->ID();
        return true;
    }
    return false;
}
private function _SendEmailToUser()
{
    $Body = "رمز التحقق الخاص بك هو: " . $this->_Code;
    return MailerController::SendEmail("hussein.a.al.mazhani@gmail.com", $this->_EmailUser, "Verify Email", $Body);
}
public function Save()
{
    switch ($this->_Mode) {
        case enMode::EmptyMode: {
                return OperationResult::FailEmptyObject;
                break;
            }
        case enMode::AddMode: {
                return $this->_AddNewOTP();
                break;
            }
    }
}
// Load ExpirationTime From Datebase.
private static function _FindOTPByUserID(int $UserID)
{
    $Query = "SELECT * from opts WHERE userID = :UserID";
    $stmt = database::Connection()->prepare($Query);
    $stmt->execute([":UserID" => $UserID]);
    $Row = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($Row) ? $Row : [];
}
public static function Find(int $UserID)
{
    $DateOTP = self::_FindOTPByUserID($UserID);
    if (empty($DateOTP)) {
        return self::_EmptyObject();
    } else {
        return self::_ConvertDBOTPToObject($DateOTP);
    }
}
// Verify User Code Will Be Here...
public static function VerifyUserCode(int $Code, int $UserID)
{
    $Otp = clsOTP::Find($UserID);
    return true;
    
}
};
