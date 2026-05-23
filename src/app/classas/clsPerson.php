<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class clsPerson
{
    private int $_ID;
    private string $_Username;
    private string $_Email;
    private string $_Password;
    private string $_Role;
    private UserStatus $_Status;
    private string $_Token;
    private DateTime $_Created_at;
    private string $_Image;

    function __construct(int $ID, string $Username, string $Email, string $Password, string $Role, int $Status, string $Token, string $Created_at, string $Image)
    {
        $this->_ID = $ID;
        $this->_Username = $Username;
        $this->_Email = $Email;
        $this->_Password = $Password;
        $this->_Role = $Role;
        $this->_Status = UserStatus::from($Status);
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
    public function setRole(string $Role): void
    {
        $this->_Role = $Role;
    }

    public function  Role(): string
    {
        return  $this->_Role;
    }

    public function setToken(string $Toke): void
    {
        $this->_Token = $Toke;
    }

    public function Token(): string
    {
        return $this->_Token;
    }
    public function setCreated_at(DateTime $Created_at)
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
    public function setStatus(int $Status): void
    {
        if ($Status >= 0 && $Status <= 3) {
            $this->_Status = UserStatus::from($Status);
        } else {
            $this->_Status = UserStatus::Pending;
        }
    }
    public function Status(): UserStatus
    {
        return $this->_Status;
    }


    public function IsAdmin(): string
    {
        return ($this->Role() == "admin");
    }





    public  function SendEmail(string $From, string $Subject, string $Body)
    {
        return MailerController::SendEmail($From, $this->Email(), $Subject, $Body);
    }
}
