<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New password</title>

    <!-- Styles -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/forms/forms.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="light">

    <div id="switch-theme-btn">
        <i class="fas fa-adjust"></i>
    </div>

    <div class="container">
        <div class="right" style="width: 100%;">
            <div class="top">
                New password
            </div>
            <?php
                include('../../app/php/functions.php');
                $userIP = getUserIP();
                if ( isset($_GET['newpwd']) && $_GET['newpwd'] == 'checkyouremail' )
                    echo"<div class='warning'>Check your email for the recovery link (look in the Spam tab too)</div>";  
                elseif ( !isset($_GET['selector']) || !isset($_GET['validator']) || (isset($_GET['newpdw']) && $_GET['newpwd'] == 'error') ) {
                    echo"<div class='warning'>It was not possible to validade your request</div>";
                } else {
                if ( isset($_GET['newpwd']) && $_GET['newpwd'] == 'pwdnotsame' )
                    echo"<div class='warning'>Put the same password in both fields</div>";
            ?>
            <form action="../../app/php/changePasswordDB.php" method="POST">
                
                <input type="hidden" name="selector" value="<?php echo$_GET['selector']; ?>">
                <input type="hidden" name="validator" value="<?php echo$_GET['validator']; ?>">

                <label for="password">New Password</label>
                <div class="show-password">
                    <input type="password" name="password" id="password">
                    <i class="fas fa-eye-slash" id="show-password-btn"></i>
                </div>
                <label for="password">Repeat New Password</label>
                <div class="show-password">
                    <input type="password" name="password-repeat" id="password">
                    <i class="fas fa-eye-slash" id="show-password-btn"></i>
                </div>

                <a href="login.php"> Remembered you password? </a>
                <input type="submit" value="Submit" name="new-password-submit">
            </form>
            <?php
                }
            ?>
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