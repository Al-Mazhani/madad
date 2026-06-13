<?php require(__DIR__ . '/../includes/headerAdmin.php'); ?>
<?php require(__DIR__ . '/../includes/session.php'); ?>
<?php require __DIR__ . '/../../../autoload.php'; ?>
<?php

class clsAddBookScrren
{

    private static function _UploadImage(array $Image)
    {
        return HandlingFiles::UploadFile($Image, __DIR__ . '/../../../uploads/image_book/', 'uploads/image_book/');
    }
    private static  function _UploadBook(array $Book)
    {
        return HandlingFiles::UploadFile($Book, __DIR__ . '/../../../uploads/book_url/', 'uploads/book_url/');
    }
    private static function AddNewBook()
    {


        $NewBook = clsBook::GetAddNewBook($_POST['bookName']);
        $NewBook->SetYear($_POST['publish_year']);
        $NewBook->SetCategoryID($_POST['id_category']);
        $NewBook->SetAuthorID($_POST['id_author']);
        $NewBook->SetPages($_POST['pages']);
        $NewBook->SetDescription($_POST['description']);
        $NewBook->SetFileType($_POST['file_type']);
        $NewBook->SetLanguage($_POST['language']);
        $NewBook->SetImage(self::_UploadImage($_FILES['image']));
        $NewBook->SetBook(self::_UploadBook($_FILES['book']));
        $NewBook->SetFileSize((int) round($_FILES['image']['size'] / 1024));
        return $NewBook->Save();
    }

    public static function ShowAddNewBookScrren()
    {
        $ResultInputs = ClsBookValidation::ValidationBook($_POST, $_FILES);
        if ($ResultInputs !== enBookError::NoErrors) {
            return $ResultInputs;
        }
        if (!clsBook::ExistsByTitle($_POST['bookName'])) {
            return self::AddNewBook();
        }
        return OperationResult::ExistTitle;
    }
}
if (isset($_POST['addBook'])) {
    $Message  = clsAddBookScrren::ShowAddNewBookScrren();
}
$allCategory = $controllBook->getAllCategory();
$authors  = $controllAuthor->getAll();
?>

<main>
    <section>
        <div class="container">
            <div class="box-add-book">
                <div class="Message">
                <?php if (isset($Message)): ?>
                    <?php

                    switch ($Message) {
                        case OperationResult::Success:
                            echo '<span class="alert-success"> Success </span>';
                            break;
                        case OperationResult::FailEmptyObject: {
                                echo '<span class="result-action"> Fail Empty Object </span>';
                                break;
                            }
                        case OperationResult::Fail: {
                                echo '<span class="result-action"> Fail </span>';
                                break;
                            }
                        case OperationResult::Updated: {
                                echo '<span class="result-action"> Updated </span>';
                                break;
                            }
                        case OperationResult::ExistTitle: {
                                echo '<span class="result-action"> Book Exist </span>';
                                break;
                            }
                        case enBookError::EmptyTitle:
                            echo '<span class="result-action">اسم الكتاب فارغ</span>';
                            break;

                        case enBookError::EmptyDescription:
                            echo '<span class="result-action">الوصف فارغ</span>';
                            break;

                        case enBookError::EmptyLanguage:
                            echo '<span class="result-action">اللغة فارغة</span>';
                            break;

                        case enBookError::EmptyFileType:
                            echo '<span class="result-action">نوع الملف فارغ</span>';
                            break;

                        case enBookError::InvalidAuthor:
                            echo '<span class="result-action">المؤلف غير صحيح</span>';
                            break;

                        case enBookError::InvalidCategory:
                            echo '<span class="result-action">التصنيف غير صحيح</span>';
                            break;

                        case enBookError::EmptyYear:
                            echo '<span class="result-action">سنة النشر فارغة</span>';
                            break;

                        case enBookError::EmptyPages:
                            echo '<span class="result-action">عدد الصفحات فارغ</span>';
                            break;

                        case enBookError::InvalidPages:
                            echo '<span class="result-action">عدد الصفحات غير صالح</span>';
                            break;

                        case enBookError::EmptyBookFile:
                            echo '<span class="result-action">ملف الكتاب غير موجود</span>';
                            break;

                        case enBookError::InvalidBookType:
                            echo '<span class="result-action">نوع ملف الكتاب غير مدعوم</span>';
                            break;

                        case enBookError::BookTooLarge:
                            echo '<span class="result-action">حجم ملف الكتاب كبير</span>';
                            break;

                        case enBookError::EmptyImage:
                            echo '<span> class="result-action"الصورة غير موجودة</span>';
                            break;

                        case enBookError::InvalidImageType:
                            echo '<span class="result-action">نوع الصورة غير مدعوم</span>';
                            break;

                        case enBookError::ImageTooLarge:
                            echo '<span class="result-action">حجم الصورة كبير</span>';
                            break;

                        case enBookError::InvalidYear:
                            echo '<span class="result-action">سنة النشر غير صحيحة</span>';
                            break;
                    }
                    ?>
                <?php endif; ?>
            </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="content-the-four-input">
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="book_name">اسم الكتاب</label>
                                <input type="text" name="bookName" id="book_name" placeholder="ادخل اسم الكتاب" required>
                            </div>
                            <div class="box-form">
                                <label for="author">المؤلف</label>
                                <select name="id_author" id="author">
                                    <?php foreach ($authors as $author): ?>
                                        <option value="<?php echo $author['id_author'] ?>">
                                            <?php echo $author['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="date">سنة النشر</label>
                                <input type="number" name="publish_year" id="date" placeholder="ادخل سنة النشر" required>
                            </div>
                            <div class="box-form">
                                <label for="category">النصنيف</label>
                                <select name="id_category" id="category">
                                    <?php foreach ($allCategory as $category): ?>
                                        <option value="<?php echo $category['id_category'] ?>">
                                            <?php echo $category['title_category'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="pages">عدد الصفحات </label>
                                <input type="number" name="pages" id="pages" min="0" placeholder="ادخل عدد الصفحات" required>
                            </div>
                            <div class="box-form">
                                <label for="file_type"> نوع الملف </label>
                                <select name="file_type" id="file_type">
                                    <option value="PDF">PDF</option>
                                    <option value="ZIP">ZIP</option>
                                </select>
                            </div>
                        </div>
                        <div class="fisrt-section">
                            <div class="box-form">
                                <label for="language">اللغة</label>
                                <select name="language" id="language">
                                    <option value="العربية">العربية</option>
                                </select>
                            </div>
                            <div class="box-form">
                                <label for="fileInputBook" class="upload-btn">إضافة كتاب</label>
                                <input type="file" name="book" id="fileInputBook" placeholder="ادخل  الكتاب" accept=".pdf" required>
                            </div>
                        </div>
                    </div>
                    <div class="box-form">
                        <label for="fileInput" class="upload-btn "> إضافة صورة</label>
                        <input type="file" id="fileInput" name="image" accept="image/*" required>
                    </div>
                    <div class="box-form">
                        <textarea name="description" id="" placeholder="وصف الكتاب"></textarea>
                    </div>
                    <button type="submit" id="btnAddNewBook" name="addBook"> إضافة</button>
                </form>
            </div>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footerAdmin.php'); ?>