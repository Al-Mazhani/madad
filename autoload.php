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
include_once  'src/app/Controller/AuthController.php';
include_once  'src/app/Controller/MailerController.php';
require_once  'public/Authentication/AuthenticationUser.php';
include_once  'src/app/helpers/handlingFiles.php';
require_once  'src/app/verfiy-email/autoload.php';
include_once  'src/app/helpers/view.php';
require_once  'config/database.php';
require_once  'Route/Route.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mailer = new PHPMailer(true);
$MailerController = new MailerController($mailer);
$ModelUser = new ModelUser();
$controllUser = new ControllUser($ModelUser);
$AuthController = new AuthController($ModelUser,$MailerController);
$ModelAdmin = new ModelAdmin();
$controllAdmin = new controllAdmin($ModelAdmin);
$ModelBook = new ModelBook();
$ModelAuthor = new ModelAuthor();
$controllBook = new ControllBook($ModelBook,$ModelAuthor,);
$controllAuthor = new ControllerAuthor($ModelAuthor);
?>