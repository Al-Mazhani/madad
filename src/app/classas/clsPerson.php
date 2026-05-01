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
    private bool $_Active;
    private string $_Token;
    private $_Created_at;
    private string $_Image;

    function __construct(int $ID, string $Username, string $Email, string $Password, string $Role, bool $Active, string $Token, string $Created_at, string $Image)
    {
        $this->_ID = $ID;
        $this->_Username = $Username;
        $this->_Email = $Email;
        $this->_Password = $Password;
        $this->_Role = $Role;
        $this->_Active = $Active;
        $this->_Token = $Token;
        $this->_Created_at = $Created_at;
        $this->_Image = $Image;
    }
    // Read Only
    public function ID()
    {
        return $this->_ID;
    }

    public function setUsername($Username): void
    {
        $this->_Username = $Username;
    }
    public function Username(): string
    {
        return $this->_Username;
    }

    public function setEmail($Email): void
    {
        $this->_Email = $Email;
    }
    public function Email(): string
    {
        return $this->_Email;
    }

    public function setPassword($Password): void
    {
        $this->_Password = $Password;
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

    public function setToke($Toke): void
    {
        $this->_Token = $Toke;
    }

    public function Toke(): string
    {
        return $this->_Token;
    }
    public function setCreated_at($Created_at)
    {
        $this->_Created_at = $Created_at;
    }

    public function Created_at()
    {
        return $this->_Created_at;
    }

    public function setImage($Image): void
    {
        $this->_Image = $Image;
    }

    public function Image(): string
    {
        return $this->_Image;
    }
    public function setActive(bool $Active): void
    {
        if ($Active == 1 || $Active == 0) {
            $this->_Active = $Active;
        }
    }
    public function Active(): bool
    {
        return $this->_Active;
    }

    public function IsActive(): bool
    {
        return $this->_Active;
    }
    public function IsAdmin(): string
    {
        return ($this->Role() == "admin");
    }
    
    

    

    public  function SendEmail(string $From,string $Subject,string $Body)
    {
        return MailerController::SendEmail($From,$this->Email(),$Subject,$Body);
    }
}
