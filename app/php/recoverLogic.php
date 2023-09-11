<?php

    session_start();

    require '../../vendor/autoload.php';

    require_once("../database/connect.php");
    require_once("../database/env.php");
    require_once("functions.php");

    $email_user = cleanEmail($_POST['email']);

    if (!empty($email_user) && isset($_POST['sender-ip']) && isset($_POST['recover-user-submit'])) {

        $query = "SELECT user_email, user_password, name_user, auth_type FROM users WHERE user_email = :email_user";

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':email_user', $email_user);

        $stmt -> execute();

        $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        if (count($return) > 0) {

            if ($return[0]['auth_type'] == 'GOOGLE') {
                header("Location: ../../public/views/recover.php?error=googleaccount");
                exit();
            }

            $name_user = $return[0]['name_user'];
            $ipDetails = getUserIP();
            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);
            $hashedToken = password_hash($token, PASSWORD_BCRYPT);

            if ($_ENV['GOOGLE_LOGIN_URI']){
                $url = $_ENV['GOOGLE_LOGIN_URI'].'public/views/'; 
            } else {
                $url = 'http://'.$_SERVER['HTTP_HOST'].'/hakkie/public/views/';
            }
            $url .= 'new-password.php?selector=' . $selector . '&validator='. bin2hex($token);
            
            $expires = date("U") + 3600; // 1 hour token validation in UNIX time

            $query = "DELETE FROM pwdreset WHERE pwdresetEmail = :email_user";
            $stmt = $conn -> prepare($query);
            $stmt -> bindValue(':email_user', $email_user);
            $stmt -> execute();

            $query = "INSERT INTO pwdreset VALUES(DEFAULT, :ipRequest , DEFAULT, :cityRequest, :regionRequest,
                     :countryRequest, :pwdResetEmail, :pwdResetSelector , :pwdResetToken, :pwdResetExpires );";

            $stmt = $conn -> prepare($query);

            if ($ipDetails->ip == 'Localhost') {
                $ipDetails->city = '';
                $ipDetails->region = '';
                $ipDetails->country = '';
            }
            
            $stmt -> bindValue(':ipRequest', $ipDetails->ip);
            $stmt -> bindValue(':cityRequest', $ipDetails->city);
            $stmt -> bindValue(':regionRequest', $ipDetails->region);
            $stmt -> bindValue(':countryRequest', $ipDetails->country);
            $stmt -> bindValue(':pwdResetEmail', $email_user);
            $stmt -> bindValue(':pwdResetSelector', $selector);
            $stmt -> bindValue(':pwdResetToken', $hashedToken);
            $stmt -> bindValue(':pwdResetExpires', $expires);

            $stmt -> execute();

            $mail = new PHPMailer\PHPMailer\PHPMailer();

            try {
                //Server settings
                $mail->isSMTP();                                        //Send using SMTP
                $mail->Host       = PHPMAILER_INFO['smtp_host'];        //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                               //Enable SMTP authentication
                $mail->Username   = PHPMAILER_INFO['mail_user'];        //SMTP username
                $mail->Password   = PHPMAILER_INFO['password_user'];    //SMTP password
                $mail->SMTPSecure = $mail::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = PHPMAILER_INFO['mail_port'];        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom(PHPMAILER_INFO['mail_user'], 'Hakkie');
                $mail->addAddress($email_user, $name_user);             //Add a recipient
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
                        Hello ".$name_user.", we received a password recovery requisition of your Hakkie account ";
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
                
                $mail->AltBody = "Hello ".$name_user.", your Email provider has disabled HTML in emails, or you deactivated it yourself manually,
                therefore, if you requested a password change/recovery of your Hakkie account";
                if ($ipDetails->ip == 'Localhost'){
                    $mail->AltBody.="by some ".$ipDetails->ip." machine";
                } else {
                    $mail->AltBody.="by the IP ".$ipDetails->ip." (Location: ".$ipDetails->country." - ".$ipDetails->region." - ".$ipDetails->city.")";
                }
                $mail->AltBody.="Copy and paste the link below to be redirected and create your new password: ".$url." 
                --This authentication link will be valid for the next 1 hour after this Email is sent.";

                $mail->send(); //echo 'Message has been sent';

                header("Location: ../../public/views/new-password.php?newpwd=checkyouremail");
                exit();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                exit();
            }
        } else {
            header("Location: ../../public/views/recover.php?error=emailnotfound");
            exit();
        }

    } else {
        header("Location: ../../public/views/new-password.php?newpwd=error");
        exit();
    }
