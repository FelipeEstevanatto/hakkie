<?php
    session_start();
    if(isset($_SESSION['isAuth'])){
        header("Location: home.php ");
	    exit();
    }

    if ( $_ENV['GOOGLE_LOGIN_URI'] != null) {
        $data_login_uri = $_ENV['GOOGLE_LOGIN_URI']."/app/google/verifyIntegrity.php";
    } else {
        $data_login_uri = 'http://localhost/hakkie/app/google/verifyIntegrity.php';
    }
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <!-- Styles -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/forms/forms.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>
    
    <!--API Google login-->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="dark">
    <div class="container">
        <div class="right" style="width: 100%;">
            <div class="top">
                Log into your account
            </div>

            <?php
                if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                    echo"<div class='feedback error'>Invalid email or password</div><br>";
                } elseif (isset($_GET['newpwd']) && $_GET['newpwd'] == 'passwordupdated') {
                    echo"<div class='feedback success'>Now login with your new password</div><br>";
                }
            ?>

            <form action="../../app/php/loginLogic.php" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password</label>
                <div class="show-password">
                    <input type="password" name="password" id="password" required>
                    <i class="fas fa-eye-slash" id="show-password-btn"></i>
                </div>

                <input type="submit" value="Submit" name="login-user-submit">
            </form>

            <a class="forgot" href="recover.php"> Forgot you password? </a>

            <div class="or">
                OR
            </div>
            <div class="google-login">
                <div id="g_id_onload"
                    data-client_id="1014049574641-u1pcchh1thdc0futl5an649j2m85222a.apps.googleusercontent.com"
                    data-context="signin"
                    data-ux_mode="popup"
                    data-login_uri="<?=$data_login_uri?>"
                    data-auto_prompt="false"
                    style="transform: scale(1.25);">
                </div>

                <div class="g_id_signin"
                    data-type="standard"
                    data-shape="pill"
                    data-theme="outline"
                    data-text="signin_with"
                    data-size="large"
                    data-logo_alignment="left"
                    style="transform: scale(1.25);">
                </div>
            </div>
            
        </div>
    </div>
    
    <a href="../../index.php">
        <div id="switch-form-btn">
            I still don't have an account
        </div>
    </a>

    <script src="../../js/showPassword.js"></script>

</body>
</html>