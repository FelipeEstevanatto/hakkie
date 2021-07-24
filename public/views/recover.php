<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover password</title>

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
                Recover you password
            </div>
            <?php
                include('../../app/php/functions.php');
                $userIP = getUserIP()->ip;
            ?>
            <form action="../../app/php/recoverLogic.php" method="POST">

                <input type="hidden" name="sender-ip" value="<?php echo$userIP; ?>">

                <?php
                if (isset($_GET['newpwd']) && $_GET['newpwd'] = 'error'){
                    echo"<div class='warning'>Use a proper email!</div>";
                }
                ?>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <a href="login.php"> Remembered you password? </a>
                <input type="submit" value="Submit" name="recover-user-submit">
            </form>

        </div>
    </div>
    
    <a href="../../index.php">
        <div id="switch-form-btn">
            I still don't have an account
        </div>
    </a>

    <script src="../../js/switchTheme.js"></script>
</body>
</html>