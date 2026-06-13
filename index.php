<?php
session_start();


// Start Model
include_once  'src/app/model/DABook.php';
include_once  'src/app/model/ModelUser.php';
include_once  'src/app/model/ModelAuthor.php';
include_once  'src/app/model/ModelAdmin.php';
// End Model
require_once  'config/database.php';
// Start Controller
include_once  'src/app/Controller/BaseController.php';
include_once  'src/app/Controller/controllBook.php';
include_once  'src/app/Controller/controllerAuthor.php';
include_once  'src/app/Controller/controllAdmin.php';
include_once  'src/app/Controller/ControllUser.php';
include_once  'src/app/Controller/AuthController.php';
include_once  'src/app/Controller/MailerController.php';
// End Controller
// Start Classas
include_once  'src/app/classas/clsPerson.php';
include_once  'src/app/classas/clsUser.php';
include_once  'src/app/classas/clsAdmin.php';
include_once  'src/app/classas/clsBook.php';
require 'librarys/vendor/autoload.php';
require_once "src/app/classas/clsExcelSheet.php";
require_once "src/app/classas/clsOTP.php";

// End Classas
require_once  'public/Authentication/AuthenticationUser.php';
include_once  'src/app/helpers/handlingFiles.php';
require_once  'src/app/verfiy-email/autoload.php';
include_once  'src/app/helpers/view.php';
require_once  'Route/Route.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// $MailerController = new MailerController($mailer);
$ModelUser = new ModelUser();
$controllUser = new ControllUser($ModelUser);
$AuthController = new AuthController($ModelUser);
$ModelAdmin = new ModelAdmin();
$controllAdmin = new controllAdmin($ModelAdmin);
$ModelBook = new DABook();
$ModelAuthor = new ModelAuthor();
$controllBook = new ControllBook($ModelBook, $ModelAuthor,);
$controllAuthor = new ControllerAuthor($ModelAuthor);





$CurrentUser = clsUser::FindByPublicID(2);




Route::get('/', function () use ($controllBook, $controllUser) {
    $ListBook = clsBook::GetListBook();
    if (isset($_COOKIE['remember_token']))
        $controllUser->checkToken($_COOKIE['remember_token']);


    require_once('src/app/view/home.php');
    // require_once('testClassas.php');
});



Route::get('/books', function () use ($controllBook) {
    $ListBook = clsBook::GetListBook();
    $allCategory = $controllBook->getAllCategory();
    require_once('src/app/view/books.php');
});
Route::get('/change-password', function () {

    require_once('src/app/view/changePass.php');
});


Route::post('/change-password', function () use ($AuthController) {
    $Message = $AuthController->ChangePassword($_POST);
    require_once('src/app/view/changePass.php');
});



Route::get('/authors', function () use ($controllAuthor) {
    $allAuthor = $controllAuthor->getAll();
    require_once('src/app/view/authors.php');
});


Route::get('/register', function () {
    require_once('src/app/view/register.php');
});
Route::get('/verify-email', function () {
    require_once('src/app/view/verify-email.php');
});
Route::post('/verify-email', function () {
    if (isset($_POST['confirm-email'])) {
        $Code = '';
        $Code .= $_POST['code1'];
        $Code .= $_POST['code2'];
        $Code .= $_POST['code3'];
        $Code .= $_POST['code4'];
        $Code .= $_POST['code5'];
        $Code .= $_POST['code6'];
        $User = clsUser::FindByEmail($_SESSION['email']);
        if (!$User->IsEmpty()) {
            $ResultValidateOTP = $User->IsOTPValid($Code);
            switch ($ResultValidateOTP) {
                case OperationResult::Success:
                    echo "Yes";
                    header('Location:/Madad/');
                    exit;
                    break;
                case OperationResult::FailOTP:
                    $Message = "Error In Code";
                    break;
            }
        }
    } else {
        echo "No";
    }
    require_once('src/app/view/verify-email.php');
});

Route::post('/register', function () {
    if (isset($_POST['submit_register'])) {
        //$ResultValidateInput clsUser::v
        $User = clsUser::GetAddNewUser($_POST['email']);
        $User->setUsername($_POST['username']);
        $User->setPassword($_POST['password']);
        $User->setPassword("user");
        // $ResultValidateInput = $User->ValidateDataUser();
        // if ($ResultValidateInput === enUserInputErrors::NoErrors) {
        $ResultSave = $User->Save();
        // }
        if ($ResultSave === OperationResult::Success) {
            if ($User->SendAccountVerificationOTP() === OperationResult::Success);
            $_SESSION['email'] = $_POST['email'];
            header('Location:/Madad/verify-email');
        }
    }

    require_once('src/app/view/register.php');
});



Route::get('/login', function () {
    require_once('src/app/view/login.php');
});

Route::post('/login', function () use ($AuthController) {

    if (isset($_POST['login'])) {
        $errorLogin = $AuthController->isLoggedIn($_POST['email'], $_POST['password']);
    }

    require_once('src/app/view/login.php');
});



Route::get('/book_ditles/id/(\d+)', function ($PublicID) use ($controllAuthor, $controllBook) {
    $infoBook = clsBook::Find($PublicID);
    $ListBook = clsBook::Find($PublicID);


    require_once('src/app/view/book_ditles.php');
});



Route::get('/info_author/id/(\d+)', function ($id) use ($controllAuthor) {
    $infoAuthor = $controllAuthor->findByID($id);
    require_once('src/app/view/info_author.php');
});



Route::get('/category', function () use ($controllBook) {

    if (isset($_GET['id_category'])) {
        $id = $_GET['id_category'];
    }

    $allCategory = $controllBook->getAllCategory();
    $category = $controllBook->getBookByCategory($id);

    require_once('src/app/view/category.php');
});



Route::get('/search', function () use ($controllBook) {

    if (isset($_GET['name'])) {
        $name = $_GET['name'];
    }

    $allCategory = $controllBook->getAllCategory();
    $search = $controllBook->search($name);

    require_once('src/app/view/search.php');
});



Route::get('/profile', function () {
    require_once('src/app/view/profile.php');
});
Route::get('/change-profile', function () {
    require_once('src/app/view/change-profile.php');
});

Route::post('/profile', function () use ($controllUser) {

    if (isset($_POST['updateProfile'])) {
        $resultUpdateProfile = $controllUser->updateProfile(
            $_POST['username'],
            $_POST['email']
        );
    }

    require_once('src/app/view/profile.php');
});


Route::get('/sign_out', function () use ($controllUser) {

    $controllUser->LogOut();
    require_once('src/app/view/sign_out.php');
});




Route::get('/homePageAdmin', function () use ($controllBook) {
    require_once('src/app/view/page-admin.php');
});
Route::post('/homePageAdmin', function () use ($controllBook) {
    $id = (int) $_POST['idDeleteBook'] ?? 0;
    echo $id;
    $controllBook->delete($id);
    require_once('src/app/view/page-admin.php');
});


Route::get('/pageAdmin', function () use ($controllAdmin) {

    $allAdmins = $controllAdmin->show();
    require_once('src/app/view/pageAdmin.php');
});

Route::get('/pageAdminAddBook', function () {
    require_once('src/app/view/pageAdminAddBook.php');
});






Route::get('/updateBook/id/(\d+)', function ($id) use ($controllAuthor, $controllBook) {

    $id = (int) $id;

    $authors  = $controllAuthor->getAll();
    $allCategory = $controllBook->getAllCategory();
    $updateBook = $controllBook->findByID($id);

    require_once('src/app/view/updateBook.php');
});


Route::post('/updateBook/id/(\d+)', function ($id) use ($controllBook, $controllAuthor) {

    $id = (int) $id;

    $authors  = $controllAuthor->getAll();
    $allCategory = $controllBook->getAllCategory();

    if (isset($_POST['updateBook'])) {

        $dataUpdateBook  = [
            "nameBook"      => $_POST['bookName'],
            "publish_year"  => $_POST['publish_year'],
            "id_category"   => $_POST['id_category'],
            "id_author"     => $_POST['id_author'],
            "pages"         => $_POST['pages'],
            "description"   => $_POST['description'],
            "file_type"     => $_POST['file_type'],
            "oldFileBook"   => $_POST['oldFileBook'],
            "oldFileSize"   => $_POST['oldFileSize'],
            "oldPathImage"  => $_POST['oldPathImage'],
            "language"      => $_POST['language'],
            "image"         => $_FILES['image_url'],
            "book"          => $_FILES['book_url']
        ];

        $Message = $controllBook->updateBook($id, $dataUpdateBook);
        $updateBook = $controllBook->findByID($id);
    }

    require_once('src/app/view/updateBook.php');
});
Route::get('/addBook', function () use ($controllAuthor, $controllBook) {

    $authors  = $controllAuthor->getAll();
    $allCategory = $controllBook->getAllCategory();

    require_once('src/app/view/addBook.php');
});
Route::get('/ManagementUsers', function () use ($CurrentUser) {


    require_once('src/app/view/ManagementUsers.php');
});


Route::post('/addBook', function () use ($controllBook, $controllAuthor) {

    $authors  = $controllAuthor->getAll();
    $allCategory = $controllBook->getAllCategory();

    if (isset($_POST['addBook'])) {
        $NewBook = clsBook::GetAddNewBook($_POST['bookName']);
        $NewBook->SetYear($_POST['publish_year']);
        $NewBook->SetCategoryID($_POST['id_category']);
        $NewBook->SetAuthorID($_POST['id_author']);
        $NewBook->SetPages($_POST['pages']);
        $NewBook->SetDescription($_POST['description']);
        $NewBook->SetFileType($_POST['file_type']);
        $NewBook->SetLanguage($_POST['language']);
        $NewBook->SetImage($_FILES['image_url']);
        $NewBook->SetBook($_FILES['book_url']);
        $Message = $NewBook->Save();
    }

    require_once('src/app/view/addBook.php');
});




Route::dispatch();
