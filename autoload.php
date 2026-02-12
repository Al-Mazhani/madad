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
include_once  'src/app/Controller/MailerController.php';
include_once  'src/app/Controller/AuthController.php';
require_once  'public/Authentication/AuthenticationUser.php';
require_once  'config/database.php';
require_once  'Route/Route.php';
require_once  'Route/web.php';
include 'validated/Request.php';
require  'src/app/verfiy-email/autoload.php';
include 'src/app/helpers/handlingFiles.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mailer = new PHPMailer(true);
$MailerController = new MailerController($mailer);
$ModelUser = new ModelUser();
$controllUser = new ControllUser($ModelUser);
$AuthController = new AuthController($ModelUser);
$ModelAdmin = new ModelAdmin();
$controllAdmin = new controllAdmin($ModelAdmin);
$ModelBook = new ModelBook();
$controllBook = new ControllBook($ModelBook);
$ModelAuthor = new ModelAuthor();
$controllAuthor = new ControllerAuthor($ModelAuthor);
