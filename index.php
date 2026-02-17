<?php

require_once 'autoload.php';

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    require_once('src/app/view/home.php');
});

/*
|--------------------------------------------------------------------------
| Books
|--------------------------------------------------------------------------
*/
Route::get('/books', function () use ($controllBook) {
    $allBooks = $controllBook->getInfoBookAndAuthor();
    $allCategory = $controllBook->getAllCategory();
    require_once('src/app/view/books.php');
});

/*
|--------------------------------------------------------------------------
| Authors
|--------------------------------------------------------------------------
*/
Route::get('/authors', function () {
    require_once('src/app/view/authors.php');
});

/*
|--------------------------------------------------------------------------
| Register
|--------------------------------------------------------------------------
*/
Route::get('/register', function () {
    require_once('src/app/view/register.php');
});

Route::post('/register', function () use ($AuthController) {

    if (isset($_POST['submit_register'])) {
        $error = $AuthController->create(
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            'user'
        );
    }

    require_once('src/app/view/register.php');
});

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    require_once('src/app/view/login.php');
});

Route::post('/login', function () use ($AuthController) {

    if (isset($_POST['login'])) {
        $errorLogin = $AuthController->isLoggedIn($_POST['email'], $_POST['password']);
    }

    require_once('src/app/view/login.php');
});

/*
|--------------------------------------------------------------------------
| Book Details
|--------------------------------------------------------------------------
*/
Route::get('/book_ditles', function () {
    require_once('src/app/view/book_ditles.php');
});

/*
|--------------------------------------------------------------------------
| Info Author
|--------------------------------------------------------------------------
*/
Route::get('/info_author', function () {
    require_once('src/app/view/info_author.php');
});

/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/
Route::get('/category', function () use ($controllBook) {

    if (isset($_GET['id_category'])) {
        $id = $_GET['id_category'];
    }

    $allCategory = $controllBook->getAllCategory();
    $category = $controllBook->getBookByCategory($id);

    require_once('src/app/view/category.php');
});

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/
Route::get('/search', function () use ($controllBook) {

    if (isset($_GET['name'])) {
        $name = $_GET['name'];
    }

    $allCategory = $controllBook->getAllCategory();
    $search = $controllBook->search($name);

    require_once('src/app/view/search.php');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::get('/profile', function () {
    require_once('src/app/view/profile.php');
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

/*
|--------------------------------------------------------------------------
| Sign Out
|--------------------------------------------------------------------------
*/
Route::get('/sign_out', function () use ($controllUser) {

    $controllUser->LogOut();
    require_once('src/app/view/sign_out.php');
});

/*
|--------------------------------------------------------------------------
| Admin Section
|--------------------------------------------------------------------------
*/

// Home Page Admin
Route::get('/homePageAdmin', function () use ($controllBook) {
    $allBooks = $controllBook->getAll();
    require_once('src/app/view/page-admin.php');
});
Route::post('/homePageAdmin', function () use ($controllBook) {
    $id = (int) $_POST['idDeleteBook'] ?? 0;
    echo $id;
    $controllBook->delete($id);
    require_once('src/app/view/page-admin.php');
});


// Page Admin
Route::get('/pageAdmin', function () use ($controllAdmin) {

    $allAdmins = $controllAdmin->show();
    require_once('src/app/view/pageAdmin.php');
});

// Add Book
Route::get('/pageAdminAddBook', function () {
    require_once('src/app/view/pageAdminAddBook.php');
});

Route::post('/pageAdminAddBook', function () use ($controllBook) {

    if (isset($_POST['addBook'])) {

        $dataAddBook  = [
            "nameBook" => $_POST['bookName'],
            "publish_year" => $_POST['publish_year'],
            "id_category" => $_POST['id_category'],
            "id_author" => $_POST['id_author'],
            "pages" => $_POST['pages'],
            "description" => $_POST['description'],
            "file_type" => $_POST['file_type'],
            "image" => $_FILES['image_url'],
            "book" => $_FILES['book_url'],
            "language" => $_POST['language']
        ];

        $Message  = $controllBook->addBook($dataAddBook);
    }

    require_once('src/app/view/pageAdminAddBook.php');
});
/*
|--------------------------------------------------------------------------
| Update Book
|--------------------------------------------------------------------------
*/

// عرض صفحة التعديل
Route::get('/updateBook/id/(\d+)', function ($id) use ($controllAuthor, $controllBook) {

    $id = (int) $id;

    $authors  = $controllAuthor->getAll();
    $allCategory = $controllBook->getAllCategory();
    $updateBook = $controllBook->findByID($id);

    require_once('src/app/view/updateBook.php');
});


// تنفيذ التحديث
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

/*
|--------------------------------------------------------------------------
| Dispatch
|--------------------------------------------------------------------------
*/
Route::dispatch();
