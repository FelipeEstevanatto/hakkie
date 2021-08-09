<?php
    session_start();
    if(isset($_SESSION['isAuth'])){
        header("Location: home.php ");
	    exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="1014049574641-u1pcchh1thdc0futl5an649j2m85222a.apps.googleusercontent.com">

    <title>Login</title>

    <!-- Styles -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/forms/forms.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>
    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

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
                <input type="email" name="email" id="email">

                <label for="password">Password</label>
                <div class="show-password">
                    <input type="password" name="password" id="password">
                    <i class="fas fa-eye-slash" id="show-password-btn"></i>
                </div>

                <input type="submit" value="Submit" name="login-user-submit">
            </form>

            <a class="forgot" href="recover.php"> Forgot you password? </a>

            <div class="or">
                OR
            </div>
            
            <a>
            <div class="google-login" id="my-signin2">
                
            </div>
            </a>
        </div>
    </div>
    
    <a href="../../index.php">
        <div id="switch-form-btn">
            I still don't have an account
        </div>
    </a>

    <script src="../../app/google/google.js"></script>
    <script src="../../js/showPassword.js"></script>

</body>
</html>