<?php

namespace Http\Services;

use Core\Session;
use Core\Authenticator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    
    private $mail = null;

    public function __construct() {
        $this->mail = new PHPMailer(true);
    }

    public function send($email, $subject, $body) {
        try {
            //Server settings
            $this->mail->SMTPDebug = 2;
            $this->mail->isSMTP();
            $this->mail->Host = $_ENV['PHPMAILER_HOST'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $_ENV['PHPMAILER_USER'];
            $this->mail->Password = $_ENV['PHPMAILER_PASSWORD'];
            $this->mail->SMTPSecure = $this->mail::ENCRYPTION_SMTPS; 
            $this->mail->Port = $_ENV['PHPMAILER_PORT'];

            //Recipients
            $this->mail->setFrom($_ENV['PHPMAILER_FROM_ADDRESS'], $_ENV['PHPMAILER_FROM_NAME']);
            $this->mail->addAddress($email);
            $this->mail->addReplyTo('no-reply@gmail.com', 'No Reply');

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->AltBody = strip_tags($body);
            $this->mail->send();
        } catch (Exception $e) {
            Session::flash('errors', ['email' => ['There was an error sending the email: '. $this->mail->ErrorInfo + $e->getMessage()  ]]);
            Session::flash('old', $_POST);
            header('location: recover');
            exit();
        }
    }
}