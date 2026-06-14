<?php
enum enResultSave
{
    case Success;
    case AuthorExists;
    case EmptyObject;
    case Failed;
}
enum enNationality: int
{
    case Nono = 0;
    case Yemeni = 1;
    case Saudi = 2;
    case Egyptian = 3;
}
enum enGender: int
{
    case Nono = 0;
    case Male = 1;
    case Female = 2;
}
class clsAuthor
{
    private enMode $_Mode;
    private int $_ID;
    private int $_PublicID;
    private string $_Name;
    private enNationality $_Nationality;
    private enGender $_Gender;
    private string $_Bio;
    private string $_Image;
    private DateTime | null $_BirthDate;
    private DateTime $_CreatedAt;

    public function __construct(enMode $Mode, int $ID, int $PublicID, string $Name, enNationality $Nationality, enGender $Gender, string $Bio, string $Image, string | null $CreatedAt, DateTime | null $BirthDate)
    {
        $this->_Mode        = $Mode;
        $this->_ID          = $ID;
        $this->_PublicID    = $PublicID;
        $this->_Name        = $Name;
        $this->_Nationality = $Nationality;
        $this->_Gender      = $Gender;
        $this->_Bio         = $Bio;
        $this->_Image       = $Image;
        $this->_BirthDate   =  $BirthDate;
        $this->_CreatedAt   =  new DateTime($CreatedAt);
    }
    private static function _GetEmptyObject(): clsAuthor
    {
        return new clsAuthor(enMode::EmptyMode, 0, 0, "", enNationality::Nono, enGender::Nono, "", "", "", null);
    }
    private static function _ConvertDataDBToObject(array $DataAuthor): clsAuthor
    {
        return new clsAuthor(enMode::UpdateMode, $DataAuthor['id_author'], $DataAuthor['public_id'], $DataAuthor['name'], enNationality::from($DataAuthor['Nationality']), enGender::from($DataAuthor['Gender']), $DataAuthor['bio'], $DataAuthor['image'], $DataAuthor['created_at'], $DataAuthor['BirthDate']);
    }
    public static function GetAddNewAuthor(string $Name)
    {
        return new clsAuthor(enMode::AddMode, 0, 0, $Name, enNationality::Nono, enGender::Nono, "", "", "", null);
    }
    // Read Only
    public function ID(): int
    {
        return $this->_ID;
    }
    public function PublicID(): int
    {
        return $this->_PublicID;
    }
    public function SetNationality(enNationality $Nationality): void
    {
        $this->_Nationality = $Nationality;
    }
    public function Nationality(): enNationality
    {
        return $this->_Nationality;
    }
    public function SetGender(enGender $Gender): void
    {
        $this->_Gender = $Gender;
    }
    public function Gender(): enGender
    {
        return $this->_Gender;
    }
    public function SetBirthDate(string $BirthDate): void
    {
        $this->_BirthDate = new DateTime($BirthDate);
    }
    public function BirthDate() : string
    {
        return $this->_BirthDate->format("Y-m-d");
    }
    public function SetName(string $Name): void
    {
        $this->_Name = $Name;
    }
    public function Name(): string
    {
        return $this->_Name;
    }
    public function SetBio(string $Bio): void
    {
        $this->_Bio = $Bio;
    }
    public function Bio(): string
    {
        return $this->_Bio;
    }
    public function SetImage(string $Image): void
    {
        $this->_Image = $Image;
    }

    public function Image(): string
    {
        return $this->_Image;
    }
    public function CreatedAt(): string
    {
        return $this->_CreatedAt->format('Y-m-d H:i:s');
    }

    public function IsEmpty(): bool
    {
        return ($this->_Mode == enMode::EmptyMode);
    }
    public function Age(): int
    {
        if ($this->_BirthDate === NULL) {
            return 0;
        }
        return $this->_BirthDate->diff(new DateTime())->y;
    }
    public function Books() {} // كتب المؤلف

    public static function FindByName(string $Name): clsAuthor
    {
        $Author = ModelAuthor::FindByName($Name);
        return (empty($Author)) ? self::_GetEmptyObject() : self::_ConvertDataDBToObject($Author);
    }
    public static function IsExistsAuthor(string $Name): bool
    {
        return ModelAuthor::ExistsByName($Name);
    }
    // Add New User
    private function _PrepareAuthorData()
    {
        $this->_PublicID = random_int(111111, 999999);
        $this->_CreatedAt = new DateTime();
    }
    private function _AddNewAuthor(): enResultSave
    {
        $this->_PrepareAuthorData();

        if (ModelAuthor::Insert($this) === OperationResult::Success) {
            $this->_Mode = enMode::UpdateMode;
            return enResultSave::Success;
        } else {
            return enResultSave::Failed;
        }
    }
    private function _Update()
    {
        return ModelAuthor::Update($this);
    }

    public function Save(): enResultSave
    {
        switch ($this->_Mode) {
            case enMode::EmptyMode: {
                    return enResultSave::EmptyObject;
                    break;
                }
            case enMode::UpdateMode: {
                    if ($this->_Update() === OperationResult::Updated) {
                        return enResultSave::Success;
                    }
                    return enResultSave::Failed;
                    break;
                }
            case enMode::AddMode: {
                    if (clsAuthor::IsExistsAuthor($this->_Name)) {
                        return enResultSave::AuthorExists;
                    }
                    return $this->_AddNewAuthor();
                    break;
                }
        }
        return enResultSave::Failed;
    }
}
