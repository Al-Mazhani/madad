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
class clsAdmin extends clsUser
{
    private int $_Permission;
     
      function __construct(enMode $Mode, int $ID, string $Username, string $Email, string $Password, string $Role, bool $Active, string $Token, string $Created_at, string $Image, string $BackgroundImage)
      {
         parent::__construct($Mode, $ID, $Username, $Email, $Password, $Role, $Active, $Token, $Created_at, $Image, $BackgroundImage);
      }
    public function setPermission(string $Permission): void
    {
        $this->_Permission = $Permission;
    }

    public function Permission(): int
    {
        return $this->_Permission;
    }
    public static function setPermissionRole(array $arrOfPermission) : int
    {
        $TotalOfPermission = 0;

         if(in_array(enPermissionRole::eAllAccess,$arrOfPermission)){
            return -1;
         }
         if(in_array(enPermissionRole::eShowAll,$arrOfPermission)){
            $TotalOfPermission += enPermissionRole::eShowAll->value;
         }
         if(in_array(enPermissionRole::eAdd,$arrOfPermission)){
            $TotalOfPermission += enPermissionRole::eAdd->value;
         }
         if(in_array(enPermissionRole::eDelete,$arrOfPermission)){
            $TotalOfPermission += enPermissionRole::eDelete->value;
         }
         if(in_array(enPermissionRole::eUpdate,$arrOfPermission)){
            $TotalOfPermission += enPermissionRole::eUpdate->value;
         }
         if(in_array(enPermissionRole::eFind,$arrOfPermission)){
            $TotalOfPermission += enPermissionRole::eFind->value;
         }

      return $TotalOfPermission;
    }
};
