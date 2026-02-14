<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends AuthController
{
    public $mailer;
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }
    public function GetCodeEmail($Code)
    {
        if ($Code != $_SESSION['confrim-code']) {
            return false;
        }
        return true;
    }
    protected function MakeCodeForEmail()
    {
        return random_int(100000, 999999);
    }

    protected  function MessageConfrimCode($code)
    {
        return '<div class="message-code"style="  width: 30rem;  height: 15rem;  text-align: center;   margin-right:10rem;  border-radius: 1px solid #3bad9a;  border: 1px solid #3bad9a;  padding: 1rem;">
        <img src="cid:logo_cid" alt="Code" style="  position: relative; left: 35%; width: 30%; height: 50%; border-radius:1rem ;">
         <h2>كود التحقق الخاص بك </h2>
         <p> استخدم هذا الكود لتأكيد بريدك الإلكتروني.</p>
         <b> ' . $code . '</b>
         <p>سينتهي هذا الكود بعد 10 دقائق.</p>
    </div>';
    }
    public function SettingSMTP()
    {
        try {

            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'husseinaldabwain@gmail.com';
            $this->mailer->Password = 'whshtreawzhshmwy';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
            return true;
        } catch (Exception $e) {
            return ['hasInputEmpty' => 'لم يتم إرسال الرمز'];
        }
    }
    public function CheckVerifyCode($code) {
        return $code == $_SESSION['confrim-code'] ? true : false;
    }
    public function SendMessageToEmail($SendEmailFrom, $userEmail)
    {
        $ErrorSendCode = $this->SettingSMTP();

        if ($ErrorSendCode !== true) {
            return $ErrorSendCode;
        }
        $code = $this->MakeCodeForEmail();
        $_SESSION['confrim-code'] = $code;
        $this->mailer->setFrom($SendEmailFrom, 'Madad');
        $this->mailer->addAddress($userEmail);

        $this->mailer->isHTML(true);
        $this->mailer->Subject = 'Madad verification code';
        $this->mailer->Body = $this->MessageConfrimCode($code);
        $this->mailer->addEmbeddedImage('C:/xampp/htdocs/Madad/public/images/iconMidad.png', 'logo_cid');
        $this->mailer->send();

        
    }
}
