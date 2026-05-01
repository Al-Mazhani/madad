<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

enum enSendEmail: int
{
    case Success = 1;
    case Failed = 0;
};
class MailerController
{
    private $mailer;
    private static function _SettingSMTP($mailer)
    {
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'hussein.a.al.mazhani@gmail.com';
        $mailer->Password = 'zpsrclmhpsjuqupl';
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Port = 587;
    }

    public static function SendEmail(string $From, string $To, string $Subject, string $Body)
    {
        $mailer = new PHPMailer(true);
        MailerController::_SettingSMTP($mailer);
        $mailer->setFrom($From, 'Madad');
        $mailer->addAddress($To);

        $mailer->isHTML(true);
        $mailer->Subject = $Subject;
        $mailer->Body = $Body;
        try {
            $mailer->send();
            return enSendEmail::Success;
        } catch (Exception $e) {
            return enSendEmail::Failed;
        }
    }
}
