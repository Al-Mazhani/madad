<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

enum enRole: int
{
    case  User = 1;
    case  Admin = 2;
    case  None = 3;
};
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
    case ExistTitle = 8;
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

class clsPerson
{
    private int $_ID;
    private string $_Username;
    private string $_Email;
    private string $_Password;
    private enRole $_Role;
    private UserStatus $_Status;
    protected string $_Token;
    private DateTime $_Created_at;
    private string $_Image;


    function __construct(int $ID, string $Username, string $Email, string $Password, enRole $Role, UserStatus $Status, string $Token, string $Created_at, string $Image)
    {
        $this->_ID = $ID;
        $this->_Username = $Username;
        $this->_Email = $Email;
        $this->_Password = $Password;
        $this->_Role = $Role;
        $this->_Status = $Status;
        $this->_Token = $Token;
        $this->_Created_at = new DateTime($Created_at);
        $this->_Image = $Image;
    }
    // anitization Date
    static protected function CleanUserName(string $Username)
    {
        return strtolower(trim(preg_replace("/[^a-zA-Z0-9_]/", '', $Username)));
    }
    static protected function CleanEmail(string $Email)
    {
        return strtolower(filter_var($Email, FILTER_SANITIZE_EMAIL));
    }
    static protected function CleanPassword(string $Password)
    {
        return trim($Password);
    }
    // Read Only
    public function ID()
    {
        return $this->_ID;
    }

    public function setUsername(string  $Username): void
    {
        $this->_Username = $this->CleanUserName($Username);
    }
    public function Username(): string
    {
        return $this->_Username;
    }

    public function setEmail(string $Email): void
    {
        $this->_Email = $this->CleanEmail($Email);
    }
    public function Email(): string
    {
        return $this->_Email;
    }

    public function setPassword(string $Password): void
    {
        $this->_Password = $this->CleanPassword($Password);
    }

    public function Password(): string
    {
        return $this->_Password;
    }
    public function setRole(enRole $Role): void
    {
        $this->_Role = $Role;
    }

    public function  Role(): enRole
    {
        return  $this->_Role;
    }



    public function Token(): string
    {
        return $this->_Token;
    }
    public function setCreated_at(DateTime $Created_at): void
    {
        $this->_Created_at = $Created_at;
    }

    public function Created_at(): DateTime
    {
        return $this->_Created_at;
    }

    public function setImage(string $Image): void
    {
        $this->_Image = $Image;
    }

    public function Image(): string
    {
        return $this->_Image;
    }
    public function setStatus(UserStatus $Status): void
    {
        $this->_Status = $Status;
    }
    public function Status(): UserStatus
    {
        return $this->_Status;
    }


    public function IsAdmin(): bool
    {
        return ($this->Role() === enRole::Admin);
    }

    public  function SendEmail(string $From, string $Subject, string $Body)
    {
        return MailerController::SendEmail($From, $this->Email(), $Subject, $Body);
    }
}
