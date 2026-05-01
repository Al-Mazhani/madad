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
class clsAdmin extends clsPerson
{
    private int $_Permission;

    public function setPermission(string $Permission): void
    {
        $this->_Permission = $Permission;
    }

    public function Permission(): int
    {
        return $this->_Permission;
    }
    private function setPermissionRole(array $arrOfPermission) : int
    {
        $TotalOfPermission = 0;

        if($arrOfPermission['eAllAccess'] == -1)
            return -1;
        foreach ($arrOfPermission as $Permission)
          {
                $TotalOfPermission += $Permission;    
          }
      return $TotalOfPermission;
    }
};
