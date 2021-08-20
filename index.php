<?php
    session_start();
    if(isset($_SESSION['isAuth'])){
        header("Location: public/views/home.php ");
	    exit();
    }

    if ( getenv('GOOGLE_LOGIN_URI') != null) {
        $data_login_uri = getenv('GOOGLE_LOGIN_URI')."/app/google/verifyIntegrity.php";
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

    <title>Create Account</title>

    <!-- Styles -->
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/forms/forms.css">

    <!--API Google login-->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="public/images/favicon.png" type="image/x-icon">

</head>
<body class="dark">

    <div class="container">
        <div class="left">
            <div class="top">
                <h1 class="logo">Hakkie</h1>                
            </div>

            <div class="content">
            A Social Media project in a Twitter like design, created just for fun and learning more. You can create you account with your Email or Google, and then go to your profile and post something nice, and share it with your friends!
            </div>
        </div>

        <div class="right">
            <div class="top">
                Create Account
            </div>

            <form action="app/php/registerLogic.php" method="POST">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password</label>
                <div class="show-password">
                    <input type="password" name="password" id="password" required>
                    <i class="fas fa-eye-slash" id="show-password-btn"></i>
                </div>

                <input type="submit" value="Submit" name="register_user_submit">
            </form>

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
    </div>

    <a href="public/views/login.php">
        <div id="switch-form-btn">
            I already have an account!
        </div>
    </a>
    
    <script src="js/showPassword.js"></script>
</body>
</html>