<?php
enum enLanguage : int {
 case Arabic  = 1;
 case English = 2;
};
 enum enFileType :int{
    case Nono = 0;
    case PDF = 1;
    case ZIP = 2;
 };
class clsBook
{
private enMode $_Mode;
private int $_ID;
private int $_PublicID;
private string $_Title;
private int $_Pages;
private enFileType $_FileType;
private int $_FileSize;
private string $_Image;
private int $_Year;
private string $_Description;
private string $_Book;
private string $_Language;
private int $_ReadCount;
private int $_CountDownload;
private DateTime $_CreatedAt;
private int $_AuthorID;
private int $_CategoryID;
public function __construct(  enMode $Mode,  int $ID,  int $PublicID,  string $Title,  int $Pages,  enFileType $FileType,  int $FileSize,  string $Image,  int $Year,  string $Description,  string $Book,  string $Language,  int $ReadCount,  int $CountDownload,  string | null $CreatedAt,  int $AuthorID,  int $CategoryID
) {
    $this->_Mode            = $Mode;
    $this->_ID              = $ID;
    $this->_PublicID        = $PublicID;
    $this->_Title           = $Title;
    $this->_Pages           = $Pages;
    $this->_FileType        = $FileType;
    $this->_FileSize        = $FileSize;
    $this->_Image           = $Image;
    $this->_Year            = $Year;
    $this->_Description     = $Description;
    $this->_Book            = $Book;
    $this->_Language        = $Language;
    $this->_ReadCount       = $ReadCount;
    $this->_CountDownload   = $CountDownload;
    $this->_CreatedAt       = new DateTime($CreatedAt);
    $this->_AuthorID        = $AuthorID;
    $this->_CategoryID      = $CategoryID;
}
private static function _GetEmptyObject()
{
    return new clsBook(enMode::EmptyMode, 0, 0, "", 0, enFileType::Nono, 0, "", 0, "", "", "", 0, 0, null, 0, 0);
}
private static  function _ConvertDateDBToObject(array $DataBook)
{
    return new clsBook(enMode::UpdateMode, $DataBook['id_book'], $DataBook['public_id'], $DataBook['title'], $DataBook['pages'], enFileType::from($DataBook['file_type']), $DataBook['file_size'], $DataBook['image'], $DataBook['year'], $DataBook['description'], $DataBook['book_url'], $DataBook['language'], $DataBook['readBook'], $DataBook['downloads'], $DataBook['created_at'], $DataBook['author_id'], $DataBook['id_category'],);
}
// Onley Read
public function ID(): int
{
    return $this->_ID;
}
// Onley Read
public function PublicID()
{
    return $this->_PublicID;
}
public function SetTitle(string $Title): void
{
    $this->_Title = $Title;
}
public function Title()
{
    return $this->_Title;
}
public function  SetPages(int $Pages): void
{
    if ($Pages <= 0)
        $this->_Pages = 0;
    else
        $this->_Pages = $Pages;
}
public function Pages()
{
    return $this->_Pages;
}
public function SetFileType(int $FileType) 
{
    $this->_FileType = enFileType::from($FileType);
}
public function FileType()
{
    return $this->_FileType;
}
public function SetFileSize(int $FileSize): void
{
    $this->_FileSize = $FileSize;
}
public function FileSize()
{
    return $this->_FileSize;
}
public function SetImage(string $Image): void
{
    $this->_Image = $Image;
}
public function Image(): string
{
    return $this->_Image;
}
public function SetYear(int $Year): void
{
    $this->_Year = $Year;
}
public function Year()
{
    return $this->_Year;
}
public function SetDescription(string $Description): void
{
    $this->_Description = $Description;
}
public function Description()
{
    return $this->_Description;
}
public function SetBook(string $Book): void
{
    $this->_Book = $Book;
}
public function BooK()
{
    return  $this->_Book;
}
public function SetLanguage(string $Language): void
{
    $this->_Language = $Language;
}
public function Language()
{
    return $this->_Language;
}
public function SetReadCount(int $ReadCount): void
{
    $this->_ReadCount = $ReadCount;
}
public function ReadCount()
{
    return $this->_ReadCount;
}
public function SetCountDownload(int $CountDownload): void
{
    $this->_CountDownload = $CountDownload;
}
public function CountDownload()
{
    return $this->_CountDownload;
}
public function SetCreatedAt(DateTime $CreatedAt): void
{
    $this->_CreatedAt = $CreatedAt;
}
public function CreatedAt(): string
{
    return $this->_CreatedAt->format('Y-m-d H:i:s');
}
public function SetAuthorID(int $AuthorID): void
{
    $this->_AuthorID = $AuthorID;
}
public function AuthorID()
{
    return $this->_AuthorID;
}
public function SetCategoryID(int $CategoryID): void
{
    $this->_CategoryID = $CategoryID;
}
public function CategoryID()
{
    return $this->_CategoryID;
}
private static function _loadAll()
{
    $query = "SELECT * FROM books  limit 20";
    $stmt = database::Connection()->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public static  function GetListBook(): array
{
    $AllBooks = self::_loadAll();
    $ObjectBook = [];
    foreach ($AllBooks as $Book) {
        array_push($ObjectBook, self::_ConvertDateDBToObject($Book));
    }
    return $ObjectBook;
}
public function IncrementReadCount() : void
{
 $this->_ReadCount++;
}
public function IncrementDownloadCount() : void
{
    $this->_CountDownload++;
}
public function IsEmpty()
{
    return ($this->_Mode == enMode::EmptyMode);
}
public static function Search(string $Keyword) : clsBook
{
    $ResultSearch = DABook::Search($Keyword);
    return (empty($ResultSearch)) ? self::_GetEmptyObject() : self::_ConvertDateDBToObject($ResultSearch);

} 

public function IsLanguage(string $Language) : bool
{
    return ($this->_Language === ucfirst($Language));
}
public static  function Find(int $PublicID): clsBook
{
    $Book = DABook::Find($PublicID);
    return (empty($Book)) ? self::_GetEmptyObject() : self::_ConvertDateDBToObject($Book);
}
public static function ExistsByPublicID(int $PublicID)
{
    $Book = clsBook::Find($PublicID);
    return (!$Book->IsEmpty());
}
public function Delete(): OperationResult
{
    $ResultDelete = DABook::delete($this->PublicID());
    if ($ResultDelete === OperationResult::Deleted) {
        $this->_Mode = enMode::EmptyMode;
        return OperationResult::Deleted;
    }
    return OperationResult::Fail;
}
private function _PrepareDataBook()
{
    $this->_PublicID = random_int(100000, 999999);
    $this->_CreatedAt = new DateTime();
}
public static  function ExistsByTitle(string $Title): bool
{
    $Result = DABook::ExistsByTitle($Title);
    return $Result;
}
public static function GetAddNewBook(string $Title)
{
    return new clsBook(enMode::AddMode, 0, 0, $Title, 0, enFileType::Nono, 0, "", 0, "", "", "", 0, 0, null, 0, 0);
}
private function _AddNewBook(): OperationResult
{
    if (clsBook::ExistsByTitle($this->_Title)) {
        return OperationResult::ExistTitle;
    }
    $this->_PrepareDataBook();
    return DABook::insertBook($this);
}
private function _Update(): OperationResult
{
    return DABook::Update($this);
}
public function Save() 
{
    switch ($this->_Mode) {
        case enMode::EmptyMode: {
                return OperationResult::FailEmptyObject;
                break;
            }
        case enMode::UpdateMode: {
                return $this->_Update();
                break;
            }
        case enMode::AddMode: {
                $ResultSave = $this->_AddNewBook();
                if ($ResultSave == OperationResult::Success) {
                    $this->_Mode = enMode::UpdateMode;
                }
                return $ResultSave;
                break;
            }
    }
}
}
