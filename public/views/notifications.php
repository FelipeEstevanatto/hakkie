<?php
    
    
    // if (!isset($_SESSION['isAuth'])) {
    //     header("Location: login.php ");
	//     exit();
    // }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/public/css/home/grid/grid.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/public/css/home/feed/feed.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?=$_COOKIE['darkMode'];?>">
    
    <?php 

        include(__DIR__ . '/../includes/tool-bar.php')

    ?>

    <div id="container">
        <div id="feed">
            <?php

            ?>
        </div>
    </div>

    <?php 

        include(__DIR__ . '/../includes/message.php')

    ?>
</body>
</html>