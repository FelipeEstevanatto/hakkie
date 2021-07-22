<?php
    session_start();
    if(isset($_SESSION['isAuth'])){
        //header("Location: public/views/home.php ");
	    //exit();
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

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>
</head>
<body class="light">

    <div id="switch-theme-btn">
        <i class="fas fa-adjust"></i>
    </div>

    <div class="container">
        <div class="left">
            <div class="top">
                <h1 class="logo">Hakkie</h1>                
            </div>

            <div class="content">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quod placeat nam nobis dolorum hic neque qui, esse ratione obcaecati quos quis voluptatem sapiente, quo maiores? Voluptate perspiciatis atque hic ratione?
            </div>
        </div>

        <div class="right">
            <div class="top">
                Create Account
            </div>

            <form action="app/php/registerLogic.php" method="POST">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">

                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <label for="password">Password</label>
                <div class="show-password">
                    <input type="password" name="password" id="password">
                    <i class="fas fa-eye-slash" id="show-password-btn"></i>
                </div>

                <input type="submit" value="Submit" name="register_user_submit">
            </form>

            <div class="or">
                OR
            </div>

            <div class="google-login">
                <img src="public/images/g-logo.png" alt="Google">
                Sign up with Google
            </div>
        </div>
    </div>

    <a href="public/views/login.php">
        <div id="switch-form-btn">
            I already have an account!
        </div>
    </a>
    
    <script src="js/switchTheme.js"></script>
    <script src="js/showPassword.js"></script>
</body>
</html>