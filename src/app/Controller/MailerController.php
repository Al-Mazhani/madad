<?php

class MailerController extends ControllUser
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
        return '    <div class="message-code">
        <img src="public/images/iconMidad.png" alt="">
         <h2>كود التحقق الخاص بك </h2>
         <p> استخدم هذا الكود لتأكيد بريدك الإلكتروني.</p>
         <b> ' . $code . '</b>
         <p>سينتهي هذا الكود بعد 10 دقائق.</p>
    </div>';
    }
    public function SettingSMTP($SendEmailFrom)
    {
        try {

            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $SendEmailFrom;
            $this->mailer->Password = 'whshtreawzhshmwy';
            $this->mailer->SMTPSecure = 'tls';
            $this->mailer->Port = 587;
            return true;
        } catch (Exception $e) {
            return ['hasInputEmpty' => 'لم يتم إرسال الرمز'];
        }
    }
    public function SendMessageToEmail($SendEmailFrom, $userEmail, $code)
    {
        if ($ErrorSendCode = $this->SettingSMTP($SendEmailFrom)) {
            return $ErrorSendCode;
        }
        $this->mailer->setFrom($SendEmailFrom, 'Madad');
        $this->mailer->addAddress($userEmail);

        $this->mailer->isHTML(true);
        $this->mailer->Subject = 'Madad verification code';
        $this->mailer->Body = $this->MessageConfrimCode($code);
        $this->mailer->send();

        return [];
    }
    protected function CheckVerifyCode()
    {
        if (true) {
            // $this->SetCookieToUser($token);
        }
    }
}
