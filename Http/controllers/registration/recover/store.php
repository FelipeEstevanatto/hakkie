<?php

namespace Http\Controllers;

use App\App;
use App\database\Database;
use Http\Forms\RecoverForm;

$db = App::resolve(Database::class);

$email = $_POST['email'];

$form = new RecoverForm([
    'email' => $email,
    'sender-ip' => $_POST['sender-ip'],
]);

$errors = $form->validateForm()->errors();

if ($form->hasErrors()) {
    ValidationException::throw($errors, $_POST);
    exit();
}

$return = $db->query('SELECT email, password, username, auth_type FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($return == null) {
    header("Location: recover?error=emailnotfound");
    exit();
}

$username = $return['username'];

$return = $db->query('SELECT email, password, username, auth_type FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($return == null) {
    header("Location: recover?error=emailnotfound");
    exit();
}

if ($return['auth_type'] == 'GOOGLE') {
    header("Location: recover?error=googleaccount");
    exit();
}

$username = $return['username'];
$ipDetails = getUserIP();
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$hashedToken = password_hash($token, PASSWORD_BCRYPT);

if ($_ENV['GOOGLE_LOGIN_URI']){
    $url = $_ENV['GOOGLE_LOGIN_URI'].'public/views/'; 
} else {
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/hakkie/public/views/';
}
$url .= 'new-password?selector=' . $selector . '&validator='. bin2hex($token);

$expires = date("U") + 3600; // 1 hour token validation in UNIX time

$db->query('DELETE FROM pwdreset WHERE pwdresetEmail = :email', [
    'email' => $email_user
]);

if ($ipDetails->ip == 'Localhost') {
    $ipDetails->city = '';
    $ipDetails->region = '';
    $ipDetails->country = '';
}

$db->query('INSERT INTO pwdreset VALUES(DEFAULT, :ipRequest , DEFAULT, :cityRequest, :regionRequest, :countryRequest, :pwdResetEmail, :pwdResetSelector , :pwdResetToken, :pwdResetExpires',[
    'ipRequest' => $ipDetails->ip,
    'cityRequest' => $ipDetails->city,
    'regionRequest' => $ipDetails->region,
    'countryRequest' => $ipDetails->country,
    'pwdResetEmail' => $email_user,
    'pwdResetSelector' => $selector,
    'pwdResetToken' => $hashedToken,
    'pwdResetExpires' => $expires
]);

$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
    //Server settings
    $mail->isSMTP();                                        //Send using SMTP
    $mail->Host       = $_ENV['PHPMAILER_HOST'];        //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                               //Enable SMTP authentication
    $mail->Username   = $_ENV['PHPMAILER_USER'];        //SMTP username
    $mail->Password   = $_ENV['PHPMAILER_PASSWORD'];    //SMTP password
    $mail->SMTPSecure = $mail::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $_ENV['PHPMAILER_PORT'];        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_ENV['mail_user'], 'Hakkie');
    $mail->addAddress($email_user, $username);             //Add a recipient
    $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Hakkie - Password Recover";
    $mail->Body    = "
    <html lang='pt-br'>
        <head>
        <meta charset='UTF-8'>
            <style>
                body{
                    width: 100%;
                    font-family: Roboto;
                    
                }
                #main{
                    width: 50%;
                    text-align: center;
                    margin: auto;
                    background-color: rgb(230, 230, 230);
                }
                h1{
                    color: blue;
                }
                #top{
                    background: 
                    linear-gradient(45deg, #7700ff, #eb4808);
                    background-clip: text; 
                    color: white;
                }
                button{
                    background-color:black;
                    color: white;
                    font-size: 1.5em; 
                    cursor: pointer;
                    padding: 1em;
                    outline: none;
                    border-radius: .5em;
                    border: none;
                }
                .texto{
                    text-align: justify; 
                    padding: 0 16px; 
                    font-size: 1.2em;
                }
            </style>
        </head>
        <body>
        <div id='main'>
        <div id='top'height='70px' width='100%'>
            <h2 style='padding-top: 30px; padding-bottom: 30px;'>Hakkie</h2>
        </div>
        <h1>Password Recover</h1>
            <p class='texto'>
            Hello ".$username.", we received a password recovery requisition of your Hakkie account ";
            if ($ipDetails->ip == 'Localhost'){
                $mail->Body.="by some ".$ipDetails->ip." machine";
            } else {
                $mail->Body.="by the IP ".$ipDetails->ip." (Location: ".$ipDetails->country." - ".$ipDetails->region." - ".$ipDetails->city.")";
            }
            $mail->Body.=", if you didn't requested or was responsible for anything, you can just ignore this email.<br><br>
            This authentication link will be valid for the next 1 hour after this Email is sent.
            Click on the button below to be redirected to create your new password or just click in the link below:
            </p><br>
            <a href='".$url."'> <button>Redefine password</button> </a>
            <br>
            <br>
            <br>
            <a href='".$url."'> ".$url." </a><br><br>
        </div>
        </body>
    </html>
    ";
    
    $mail->AltBody = "Hello ".$username.", your Email provider has disabled HTML in emails, or you deactivated it yourself manually,
    therefore, if you requested a password change/recovery of your Hakkie account";
    if ($ipDetails->ip == 'Localhost'){
        $mail->AltBody.="by some ".$ipDetails->ip." machine";
    } else {
        $mail->AltBody.="by the IP ".$ipDetails->ip." (Location: ".$ipDetails->country." - ".$ipDetails->region." - ".$ipDetails->city.")";
    }
    $mail->AltBody.="Copy and paste the link below to be redirected and create your new password: ".$url." 
    --This authentication link will be valid for the next 1 hour after this Email is sent.";

    $mail->send(); //echo 'Message has been sent';

    header("Location: new-password?newpwd=checkyouremail");
    exit();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    exit();
}
