<?php
    session_start();
    
    if (!isset($_SESSION['isAuth'])) {
        header("Location: login.php ");
	    exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - <?='aaa'?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="../css/home/grid/grid.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="../css/home/feed/feed.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?= $_SESSION['darkMode'];?>">
    
    <?php 

        include('../includes/tool-bar.php');

    ?>

    <div id="container">
        <div id="feed">
            <?php
                include('../../app/php/showPosts.php');
                //print_r();
                showPosts( 8 , 10 , 'posts');
            ?>
        </div>
    </div>

    <?php 

        include('../includes/message.html')

    ?>
</body>
</html>