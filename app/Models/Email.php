<?php

namespace App\Models;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer;

        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->Port = 587;

        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->SMTPDebug = 3;

        $this->mailer->Username = 'custom.cms.dummy@gmail.com';
        $this->mailer->Password = 'password1234_';

        $this->mailer->From = 'support@cms.com';
        $this->mailer->FromName = 'Custom CMS Support';
        $this->mailer->addReplyTo('reply@cms.com', 'Reply address');
    }

    public function send($to, $subject, $body)
    {
        $this->mailer->addAddress($to);
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;

        if (!$this->mailer->send()) {
            throw new Exception($this->mailer->ErrorInfo);
        }
    }
}
