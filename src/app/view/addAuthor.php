<?php require(__DIR__ . '/../includes/headerAdmin.php');
require __DIR__ . '/../../../autoload.php';

class clsAddAuthorScreen
{


    private static function _UploadImage(array $Image)
    {
        return HandlingFiles::UploadFile($Image, __DIR__ . '/../../../uploads/Author_profile/', 'uploads/Author_profile/');
    }
    private static function _AddAuthor()
    {
        $NewAuthor = clsAuthor::GetAddNewAuthor($_POST['Name']);
        $NewAuthor->SetBio($_POST['Bio']);
        $NewAuthor->SetImage(self::_UploadImage($_FILES['Image']));
        $NewAuthor->SetNationality(enNationality::from($_POST['Nationality']));
        $NewAuthor->SetGender(enGender::from($_POST['Gender']));
        $NewAuthor->SetBirthDate($_POST['BirthDate']);
        return $NewAuthor->Save();
    }

    public static function ShowAddAuthorScreen()
    {
        // $ResultImage = ClsBookValidation::validateFileInputImage($_FILES['Image']);
        // if($ResultImage !== enBookError::NoErrors)
        // {
        //     return $ResultImage;
        // }

        if (clsAuthor::IsExistsAuthor($_POST['Name'])) {
            return false;
        } else {
            return self::_AddAuthor();
        }
    }
};
if (isset($_POST['addauthor'])) {

    print_r(clsAddAuthorScreen::ShowAddAuthorScreen());
}
?>
<main>
    <section>
        <div class="container">

            <div class="box-add-book">

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="content-the-four-input">
                        <div class="box-form input-author">
                            <label for="author_name">اسم المؤلف</label>
                            <input type="text" name="Name" id="author_name" placeholder="ادخل اسم الكتاب" required>
                        </div>

                        <div class="box-form input-author">
                            <label for="author_name"> تاريخ الميلاد</label>
                            <input type="date" name="BirthDate" id="BirthDate" required>
                        </div>
                    </div>
                    <div class="content-the-four-input">
                        <div class="box-form input-author">
                            <label for="Gender"> Gender</label>
                            <select name="Gender" id="Gender" class="Input-Gender">
                                <option value="<?= enGender::Male->value ?>"><?= enGender::Male->name ?></option>
                                <option value="<?= enGender::Female->value ?>"><?= enGender::Female->name ?></option>
                            </select>
                        </div>
                        <div class="box-form input-author">
                            <label for="Nationality"> Nationality</label>
                            <select name="Nationality" id="Nationality" class="Input-Nationality">
                                <?php foreach (enNationality::cases() as $Nationality): ?>
                                    <option value="<?= $Nationality->value ?>"><?= $Nationality->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="content-the-four-input">
                        <div class="box-form input-author">
                            <label for="fileInput" class="upload-btn fileinputImageAuthor"> إضافة صورة</label>
                            <input type="file" id="fileInput" name="Image" accept="image/*">
                        </div>

                    </div>

                    <div class="box-form">
                        <textarea name="Bio">

                      </textarea>
                        <button type="submit" id="btnAddNewauthor" name="addauthor"> إضافة</button>
                </form>
            </div>
        </div>
        </div>
    </section>
</main>
<?php include(__DIR__ . '/../includes/footerAdmin.php'); ?>