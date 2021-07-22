<?php
    session_start();
    if(isset($_SESSION['isAuth'])){
        //header("Location: home.php ");
	    //exit();
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
</head>
<body class="light">

    <div id="switch-theme-btn">
        <i class="fas fa-adjust"></i>
    </div>

    <div class="container">
        <div class="right" style="width: 100%;">
            <div class="top">
                Log into your account
            </div>

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

            <div class="or">
                OR
            </div>

            <div class="google-login">
                <img src="../images/g-logo.png" alt="Google">
                Login with Google
            </div>
        </div>
    </div>
    
    <a href="../../index.php">
        <div id="switch-form-btn">
            I still don't have an account
        </div>
    </a>

    <script src="../../js/switchTheme.js"></script>
    <script src="../../js/showPassword.js"></script>
</body>
</html>