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
    <title>Home</title>

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

        include('../includes/tool-bar.php')

    ?>

    <div id="container">

        <div id="feed">
            <?php

                include('../../app/php/showPosts.php');
                require_once('../../app/database/connect.php');

                $query = 'SELECT DISTINCT id_user FROM users INNER JOIN posts ON fk_owner = id_user';

                $stmt = $conn-> query($query);

                $return = $stmt -> fetchAll();

                foreach ($return as $user) {
                    //$user = shuffle($user);
                    //var_dump($user);
                    showPosts( $user['id_user'] , 10 , 'posts');
                }

            ?>
        </div>
    </div>

    <?php 

        include('../includes/message.html')

    ?>

    <script src="../../js/feedbuild.js"></script>

</body>
</html>