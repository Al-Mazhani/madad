    <?php

    require_once 'autoload.php';
    Route::get('/', function () use ($controllBook, $controllUser) {
        $allBooks = $controllBook->getInfoBookAndAuthor();
        if (isset($_COOKIE['remember_token'])) {
            $getToken  = $controllUser->checkToken($_COOKIE['remember_token']);
        }
        require_once('src/app/view/home.php');
    });

    Route::get('/books', function () use ($controllBook) {
        $allBooks = $controllBook->getInfoBookAndAuthor();
        $allCategory = $controllBook->getAllCategory();
        if (isset($_GET['id_category'])) {
            $id = $_GET['id_category'];
            $bookByCategory = $controllBook->getBookByCategory($id);
        }

        require_once('src/app/view/books.php');
    });
    Route::get('/register', function () {
        view('register');
    });
    Route::get('/login', function () {
        view('login');
    });
    Route::post('/login', function () use ($AuthController, $controllAdmin) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['login'])) {
                if ($_POST['login-as'] == 'user') {

                    $errorLogin = $AuthController->isLoggedIn($_POST['email'], $_POST['password']);
                } else {
                    $errorLogin = $controllAdmin->isLoggedIn($_POST['email'], $_POST['password']);
                }
            }
        }
    });
    Route::post('/register', function () use ($AuthController) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_register'])) {
            $error = $AuthController->create($_POST['username'], $_POST['email'], $_POST['password'], 'user');
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code1'],$_POST['code2'],$_POST['code3'],$_POST['code4'],$_POST['code5'],$_POST['code6'])){
            $Code = "";
            $Code .= $_POST['code1'];
            $Code .= $_POST['code2'];
            $Code .= $_POST['code3'];
            $Code .= $_POST['code4'];
            $Code .= $_POST['code5'];
            $Code .= $_POST['code6'];
            

        }

        require "src/app/view/register.php";
    });
    Route::get('/profile', function () {
        view('profile');
    });
    Route::get('/authors', function () use ($controllAuthor) {
        $allAuthor = $controllAuthor->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['name'])) {
            $SearchAuthor = $controllAuthor->search($_GET['name']);
        }

        require "src/app/view/authors.php";
    });

    Route::get('/book_ditles/id/(\d{6})', function ($bookID) use ($controllBook) {
        $infoBook = $controllBook->getInfoBookByID($bookID);
        if (isset($_POST['idDownloadBook'])) {
            $controllBook->incrementDonwnload($_POST['idDownloadBook']);
        }
        if (isset($_POST['idReadBook'])) {
            $controllBook->incrementReadBook($_POST['idReadBook']);
        }
        $OtherBooks = $controllBook->OtherBooks();
        $id_category = $infoBook['category_public_id'];
        $bookByCategory = $controllBook->getBookByCategory($id_category);
        require "src/app/view/book_ditles.php";
    });
    Route::get("/info_author/id/(\d{6})", function ($id_author) use ($controllAuthor) {

        $infoAuthor = $controllAuthor->findByID($id_author);
        $allBooksAuthor = $controllAuthor->findMoreOne($id_author);
        require "src/app/view/info_author.php";
    });

    Route::get('', function () use ($controllBook) {
        $allBooks = $controllBook->getAll();
        if (isset($_POST['idDeleteBook'])) {
            $controllBook->delete($_POST['idDeleteBook']);
        }
        if (isset($_GET['search-for'])) {
            $resultSearchBook = $controllBook->search($_GET['search-for']);
        }
        require "src/app/view/info_author.php";
    });
    Route::get('/sign_out', function () use ($controllUser) {
                $controllUser->LogOut();

        require "src/app/view/sign_out.php";
    });
    Route::get('/verify-email', function () {
        require "src/app/view/verify-email.php";
    });
    Route::dispatch();
    // switch ($URL) {
    //     case Route::home->value:
    //         
    //         break;
    //     case Route::books->value:
    //   uire_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::authors->value:

    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::register->value:
    //         if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_register'])) {
    //             $error = $AuthController->create($_POST['username'], $_POST['email'], $_POST['password'], 'user');
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::login->value:
    //         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //             if (isset($_POST['login'])) {
    //                 if ($_POST['login-as'] == 'user') {

    //                     $errorLogin = $AuthController->isLoggedIn($_POST['email'], $_POST['password']);
    //                 } else {
    //                     $errorLogin = $controllAdmin->isLoggedIn($_POST['email'], $_POST['password']);
    //                 }
    //             }
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;

    //     case Route::book_ditles->value:


    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::info_author->value:
    //    
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::category->value:
    //         if (isset($_GET['id_category'])) {
    //             $id = $_GET['id_category'];
    //         }
    //         $allCategory = $controllBook->getAllCategory();
    //         $category = $controllBook->getBookByCategory($id);
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::search->value:
    //         if (isset($_GET['name'])) {
    //             $name = $_GET['name'];
    //         }
    //         $allCategory = $controllBook->getAllCategory();
    //         $search = $controllBook->search($name);
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::profile->value:
    //         if ($_SERVER['REQUEST_METHOD'] ==  'POST') {

    //             if (isset($_POST['updateProfile'])) {

    //                 $resultUpdateProfile = $controllUser->updateProfile($_POST['username'], $_POST['email']);
    //             }
    //         }

    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::sign_out->value:
    //         $controllUser->LogOut();
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     // Admin
    //     case Route::homePageAdmin->value:
    //      
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::pageAdmin->value:
    //         $allAdmins = $controllAdmin->show();
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::pageAdminAddBook->value:

    //         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBook'])) {
    //             $dataAddBook  = [
    //                 "nameBook" => $_POST['bookName'],
    //                 "publish_year" => $_POST['publish_year'],
    //                 "id_category" => $_POST['id_category'],
    //                 "id_author" => $_POST['id_author'],
    //                 "pages" => $_POST['pages'],
    //                 "description" => $_POST['description'],
    //                 "file_type" => $_POST['file_type'],
    //                 "image" => $_FILES['image_url'],
    //                 "book" => $_FILES['book_url'],
    //                 "language" => $_POST['language']
    //             ];

    //             $Message  = $controllBook->addBook($dataAddBook);
    //         }

    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::pageAdminAddAdmin->value:
    //         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //             if (isset($_POST['btnAddNewAdmin'])) {
    //                 $message = $AuthController->create($_POST['adminName'], $_POST['adminEmail'], $_POST['adminPassword'], $_POST['role']);
    //             }
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::managemtAuthor->value:
    //         $allAuthors = $controllAuthor->getAll();
    //         if (isset($_GET['search-for'])) {
    //             $resultSearchAuthor = $controllAuthor->search($_GET['search-for']);
    //         }
    //         if (isset($_GET['deleteAuht'])) {
    //             $controllAuthor->delete($_GET['deleteAuht']);
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::addAuthor->value:
    //         if (isset($_POST['addauthor'])) {
    //             $nameAuthor = $_POST['authorName'];
    //             $imageURLAuthro = $_FILES['imageURLAuthro'];
    //             $bioAuthro = $_POST['bio'];
    //             $Message = $controllAuthor->addAuthor($nameAuthor, $imageURLAuthro, $bioAuthro);
    //         }
    //         if (isset($_GET['updateAuthor'])) {
    //             $updateAuthor = $controllAuthor->findByID($_GET['updateAuthor']);
    //         }
    //         if (isset($_POST['update'])) {
    //             $resultUpdateAuhtor = $controllAuthor->update($_POST['id'], $_POST['authorName'], $_FILES['imageURLAuthro'], $_POST['oldImage'], $_POST['bio']);
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::updateBook->value:
    //         $authors  = $controllAuthor->getAll();
    //         $allCategory = $controllBook->getAllCategory();
    //         if (isset($_GET['ID'])) {

    //             $updateBook = $controllBook->findByID($_GET['ID']);

    //             if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateBook'])) {
    //                 $id = $_GET['ID'] ?? 0;

    //                 $dataUpdateBook  = [
    //                     "nameBook" => $_POST['bookName'],
    //                     "publish_year" => $_POST['publish_year'],
    //                     "id_category" => $_POST['id_category'],
    //                     "id_author" => $_POST['id_author'],
    //                     "pages" => $_POST['pages'],
    //                     "description" => $_POST['description'],
    //                     "file_type" => $_POST['file_type'],
    //                     "oldFileBook" => $_POST['oldFileBook'],
    //                     "oldFileSize" => $_POST['oldFileSize'],
    //                     "oldPathImage" => $_POST['oldPathImage'],
    //                     "language" => $_POST['language'],
    //                     "image" => $_FILES['image_url'],
    //                     "book" => $_FILES['book_url']
    //                 ];
    //                 $Message = $controllBook->updateBook($id, $dataUpdateBook);
    //             }
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::ManagementUsers->value:
    //         $allUsers = $controllUser->show();
    //         if (isset($_GET['id'])) {
    //             $controllUser->findByID($_GET['id']);
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     case Route::verifyEmail->value:
    //         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm-email'])) {
    //             $code = "";
    //             $code .= $_POST['code1'];
    //             $code .= $_POST['code2'];
    //             $code .= $_POST['code3'];
    //             $code .= $_POST['code4'];
    //             $code .= $_POST['code5'];
    //             $code .= $_POST['code6'];
    //             $MailerController->GetCodeEmail($code);
    //         }
    //         require_once('src/app/view/' . $route[$URL]);
    //         break;
    //     default:
    // }
