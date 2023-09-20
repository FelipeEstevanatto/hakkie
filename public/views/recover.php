<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover password</title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/style.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/forms/forms.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="dark">
    <div class="container">
        <div class="right" style="width: 100%;">
            <div class="top">
                Recover you password
            </div>
            <?php
                include(__DIR__.'/../../app/php/functions.php');
                $userIP = getUserIP()->ip;
            ?>
            <form action="recoverLogic" method="POST">

                <input type="hidden" name="sender-ip" value="<?php echo$userIP; ?>">

                <?php
                if (isset($_GET['newpwd']) && $_GET['newpwd'] = 'error'){
                    echo"<div class='warning'>Use a proper email!</div>";
                }
                ?>
                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <input type="submit" value="Submit" name="recover-user-submit">
            </form>

            <a class="forgot" href="login"> Remembered you password? </a>
        </div>
    </div>
    
    <a href="index">
        <div id="switch-form-btn">
            I still don't have an account
        </div>
    </a>
    <script>
        let imgloading = document.createElement('img');
        imgloading.src = '../images/loading-buffering.gif';
        imgloading.className = '';

    </script>
</body>
</html>