    <?php
    session_start();

    include_once  'src/app/model/ModelBook.php';
    include_once  'src/app/model/ModelUser.php';
    include_once  'src/app/model/ModelAuthor.php';
    include_once  'src/app/model/ModelAdmin.php';
    include_once  'src/app/Controller/BaseController.php';
    include_once  'src/app/Controller/controllBook.php';
    include_once  'src/app/Controller/controllerAuthor.php';
    include_once  'src/app/Controller/controllAdmin.php';
    include_once  'src/app/Controller/ControllUser.php';
    require_once  'config/database.php';
    include 'validated/Request.php';
    require  'src/app/verfiy-email/autoload.php';

    include 'src/app/helpers/handlingFiles.php';
    $IP_address_user = $_SERVER['REMOTE_ADDR'];


    $ModelUser = new ModelUser();
    $controllUser = new ControllUser($ModelUser);
    $ModelAdmin = new ModelAdmin();
    $controllAdmin = new controllAdmin($ModelAdmin);
    $ModelBook = new ModelBook();
    $controllBook = new ControllBook($ModelBook);
    $ModelAuthor = new ModelAuthor();
    $controllAuthor = new ControllerAuthor($ModelAuthor);

    $URL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $parts = explode('/', $URL);
    enum Route: string
    {
        case home = '/Madad/';
        case books = '/Madad/books';
        case category = '/Madad/category';
        case search = '/Madad/search';
        case authors = '/Madad/authors';
        case register = '/Madad/register';
        case login = '/Madad/login';
        case book_ditles = '/Madad/book_ditles';
        case info_author = '/Madad/info_author';
        case profile = '/Madad/profile';
        case sign_out = '/Madad/sign_out';
        case homePageAdmin = '/Madad/homeAdmin';
        case managemtAuthor = '/Madad/magagement-atuhor';
        case ManagementUsers = '/Madad/ManagementUsers';
        case addAuthor = '/Madad/addAuthor';
        case pageAdmin = '/Madad/admin';
        case pageAdminAddBook = '/Madad/addBook';
        case pageAdminAddAdmin = '/Madad/addAdmin';
        case errorURL = '/Madad/errorURL';
        case updateBook = '/Madad/update';
        case verifyEmail = '/Madad/verify-email';
    }
    $route = [
        Route::home->value => 'home.php',
        Route::books->value => 'books.php',
        Route::category->value => 'category.php',
        Route::search->value => 'search.php',
        Route::authors->value => 'authors.php',
        Route::register->value => 'register.php',
        Route::login->value => 'login.php',
        Route::errorURL->value => 'errorURL.php',
        Route::book_ditles->value => 'book_ditles.php',
        Route::info_author->value => 'info_author.php',
        Route::profile->value => 'profile.php',
        Route::sign_out->value => 'sign_out.php',
        Route::homePageAdmin->value => 'page-admin.php',
        Route::addAuthor->value => 'addAuthor.php',
        Route::managemtAuthor->value => 'manageAuthor.php',
        Route::ManagementUsers->value => 'ManagementUsers.php',
        Route::pageAdmin->value => 'admin.php',
        Route::pageAdminAddBook->value => 'addBook.php',
        Route::updateBook->value => 'updateBook.php',
        Route::verifyEmail->value => 'verify-email.php',
        '/Madad/addAdmin' => 'addAdmin.php',
    ];
    if (array_key_exists($URL, $route)) {
        switch ($URL) {
            case Route::home->value:
                $allBooks = $controllBook->getInfoBookAndAuthor();
                if (isset($_COOKIE['remember_token'])) {
                    $getToken  = $controllUser->checkToken($_COOKIE['remember_token']);
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::books->value:
                $allBooks = $controllBook->getInfoBookAndAuthor();
                $allCategory = $controllBook->getAllCategory();
                if (isset($_GET['id_category'])) {
                    $id = $_GET['id_category'];
                    $bookByCategory = $controllBook->getBookByCategory($id);
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::authors->value:
                $allAuthor = $controllAuthor->getAll();
                if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['name'])) {
                    $SearchAuthor = $controllAuthor->search($_GET['name']);
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::register->value:
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_register'])) {
                    $error = $controllUser->create($_POST['username'], $_POST['email'], $_POST['password'], 'user');
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::login->value:
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['login'])) {
                        if ($_POST['login-as'] == 'user') {

                            $errorLogin = $controllUser->isLoggedIn($_POST['email'], $_POST['password']);
                        } else {
                            $errorLogin = $controllAdmin->isLoggedIn($_POST['email'], $_POST['password']);
                        }
                    }
                }
                require_once('src/app/view/' . $route[$URL]);
                break;

            case Route::book_ditles->value:

                if (isset($_GET['bookID'])) {
                    $id = $_GET['bookID'];
                    $infoBook = $controllBook->getInfoBookByID($id);
                }
                if (isset($_POST['idDownloadBook'])) {
                    $controllBook->incrementDonwnload($_POST['idDownloadBook']);
                }
                if (isset($_POST['idReadBook'])) {
                    $controllBook->incrementReadBook($_POST['idReadBook']);
                }
                $OtherBooks = $controllBook->OtherBooks();
                $id_category = $infoBook['category_public_id'];
                $bookByCategory = $controllBook->getBookByCategory($id_category);
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::info_author->value:
                if (isset($_GET['authroID'])) {
                    $id = $_GET['authroID'];
                }

                $infoAuthor = $controllAuthor->findByID($id);
                $allBooksAuthor = $controllAuthor->findMoreOne($id);
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::category->value:
                if (isset($_GET['id_category'])) {
                    $id = $_GET['id_category'];
                }
                $allCategory = $controllBook->getAllCategory();
                $category = $controllBook->getBookByCategory($id);
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::search->value:
                if (isset($_GET['name'])) {
                    $name = $_GET['name'];
                }
                $allCategory = $controllBook->getAllCategory();
                $search = $controllBook->search($name);
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::profile->value:
                if ($_SERVER['REQUEST_METHOD'] ==  'POST') {

                    if (isset($_POST['updateProfile'])) {

                        $resultUpdateProfile = $controllUser->updateProfile($_POST['username'], $_POST['email']);
                    }
                }

                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::sign_out->value:
                $controllUser->LogOut();
                require_once('src/app/view/' . $route[$URL]);
                break;
            // Admin
            case Route::homePageAdmin->value:
                $allBooks = $controllBook->getAll();
                if (isset($_POST['idDeleteBook'])) {
                    $controllBook->delete($_POST['idDeleteBook']);
                }
                if (isset($_GET['search-for'])) {
                    $resultSearchBook = $controllBook->search($_GET['search-for']);
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::pageAdmin->value:
                $allAdmins = $controllAdmin->show();
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::pageAdminAddBook->value:

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBook'])) {
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
                $allCategory = $controllBook->getAllCategory();
                $authors = $controllAuthor->getAll();
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::pageAdminAddAdmin->value:
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['btnAddNewAdmin'])) {
                        $message = $controllAdmin->create($_POST['adminName'], $_POST['adminEmail'], $_POST['adminPassword'], $_POST['role']);
                    }
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::managemtAuthor->value:
                $allAuthors = $controllAuthor->getAll();
                if (isset($_GET['search-for'])) {
                    $resultSearchAuthor = $controllAuthor->search($_GET['search-for']);
                }
                if (isset($_GET['deleteAuht'])) {
                    $controllAuthor->delete($_GET['deleteAuht']);
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::addAuthor->value:
                if (isset($_POST['addauthor'])) {
                    $nameAuthor = $_POST['authorName'];
                    $imageURLAuthro = $_FILES['imageURLAuthro'];
                    $bioAuthro = $_POST['bio'];
                    $Message = $controllAuthor->addAuthor($nameAuthor, $imageURLAuthro, $bioAuthro);
                }
                if (isset($_GET['updateAuthor'])) {
                    $updateAuthor = $controllAuthor->findByID($_GET['updateAuthor']);
                }
                if (isset($_POST['update'])) {
                    $resultUpdateAuhtor = $controllAuthor->update($_POST['id'], $_POST['authorName'], $_FILES['imageURLAuthro'], $_POST['oldImage'], $_POST['bio']);
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::updateBook->value:
                $authors  = $controllAuthor->getAll();
                $allCategory = $controllBook->getAllCategory();
                if (isset($_GET['ID'])) {

                    $updateBook = $controllBook->findByID($_GET['ID']);

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateBook'])) {
                        $id = $_GET['ID'] ?? 0;

                        $dataUpdateBook  = [
                            "nameBook" => $_POST['bookName'],
                            "publish_year" => $_POST['publish_year'],
                            "id_category" => $_POST['id_category'],
                            "id_author" => $_POST['id_author'],
                            "pages" => $_POST['pages'],
                            "description" => $_POST['description'],
                            "file_type" => $_POST['file_type'],
                            "oldFileBook" => $_POST['oldFileBook'],
                            "oldFileSize" => $_POST['oldFileSize'],
                            "oldPathImage" => $_POST['oldPathImage'],
                            "language" => $_POST['language'],
                            "image" => $_FILES['image_url'],
                            "book" => $_FILES['book_url']
                        ];
                        $Message = $controllBook->updateBook($id, $dataUpdateBook);
                    }
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::ManagementUsers->value:
                $allUsers = $controllUser->show();
                if (isset($_GET['id'])) {
                    $controllUser->findByID($_GET['id']);
                }
                require_once('src/app/view/' . $route[$URL]);
                break;
            case Route::verifyEmail->value:
                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm-email'])){
                        $code = "";
                        $code .= $_POST['code1'];
                        $code .= $_POST['code2'];
                        $code .= $_POST['code3'];
                        $code .= $_POST['code4'];
                        $code .= $_POST['code5'];
                        $code .= $_POST['code6'];
                        $controllUser->GetCodeEmail($code);
                    }
                require_once('src/app/view/' . $route[$URL]);
                break;
            default:
                require_once('src/app/view/errorURL.php');
        }
    } else {
        require_once('src/app/view/errorURL.php');
    }
