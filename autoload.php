<?php
include_once __DIR__ . '/src/app/model/DABook.php';
include_once __DIR__ . '/src/app/model/ModelUser.php';
include_once __DIR__ . '/src/app/model/ModelAuthor.php';
include_once __DIR__ . '/src/app/model/ModelAdmin.php';

include_once __DIR__ . '/src/app/Controller/BaseController.php';
include_once __DIR__ . '/src/app/Controller/controllBook.php';
include_once __DIR__ . '/src/app/Controller/controllerAuthor.php';
include_once __DIR__ . '/src/app/Controller/controllAdmin.php';
include_once __DIR__ . '/src/app/Controller/ControllUser.php';
include_once __DIR__ . '/src/app/Controller/AuthController.php';
include_once __DIR__ . '/src/app/Controller/MailerController.php';

include_once __DIR__ . '/src/app/classas/clsPerson.php';
include_once __DIR__ . '/src/app/classas/clsUser.php';
include_once __DIR__ . '/src/app/classas/clsAdmin.php';
include_once __DIR__ . '/src/app/classas/clsBook.php';
include_once __DIR__ . '/src/app/classas/clsBookValidation.php';

include_once __DIR__ . '/src/app/helpers/handlingFiles.php';
include_once __DIR__ . '/config/database.php';
include_once __DIR__ . '/Route/Route.php';
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
$controllBook = new ControllBook($ModelBook,$ModelAuthor,);
$controllAuthor = new ControllerAuthor($ModelAuthor);
 

?>