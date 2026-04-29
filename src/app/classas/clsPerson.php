<?php
class clsPerson
{
    private $_ID;
    private $_Username;
    private $_Email;
    private $_Password;
    private $_Role;
    private $_Active;
    private $_Token;
    private $_Created_at;
    private $_Image;

    function __construct(int $ID, string $Username, string $Email, string $Password, int $Role, bool $Active, string $Token, string $Created_at, string $Image)
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
    public function ID()
    {
        return $this->_ID;
    }

    public function setUsername($Username)
    {
        $this->_Username = $Username;
    }
    public function Username()
    {
        return $this->_Username;
    }

    public function setEmail($Email)
    {
        $this->_Email = $Email;
    }
    public function Email()
    {
        return $this->_Email;
    }

    public function setPassword($Password)
    {
        $this->_Password = $Password;
    }

    public function Password()
    {
        return $this->_Password;
    }
    public function setRole($Role)
    {
        $this->_Role = $Role;
    }

    public function  Role()
    {
        return  $this->_Role;
    }

    public function setToke($Toke)
    {
        $this->_Token = $Toke;
    }

    public function Toke()
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

    public function setImage($Image)
    {
        $this->_Image = $Image;
    }

    public function Image()
    {
        return $this->_Image;
    }
    public function setActive(bool $Active)
    {
        if ($Active == 1 || $Active == 0) {
            $this->_Active = $Active;
        }
    }
    public function Active()
    {
        return $this->_Active;
    }

    protected function IsActive() : bool
    {
        return $this->_Active;
    }
    protected function IsAdmin() : bool
    {
     return $this->_Role == 1;
    }
}
