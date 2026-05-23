<?php
// Start Model
include_once  'src/app/model/ModelBook.php';
include_once  'src/app/model/ModelUser.php';
include_once  'src/app/model/ModelAuthor.php';
include_once  'src/app/model/ModelAdmin.php';
// End Model
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

// End Classas
require_once  'public/Authentication/AuthenticationUser.php';
include_once  'src/app/helpers/handlingFiles.php';
require_once  'src/app/verfiy-email/autoload.php';
include_once  'src/app/helpers/view.php';
require_once  'config/database.php';
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
$controllBook = new ControllBook($ModelBook,$ModelAuthor,);
$controllAuthor = new ControllerAuthor($ModelAuthor);
 

?>