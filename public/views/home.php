<?php
    require_once(__DIR__ . '/../../bootstrap.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/home/grid/grid.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/style.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/home/feed/feed.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= $GLOBALS['base_url'] ?>public/images/favicon.png" type="image/x-icon">
</head>
<body class="<?=$_COOKIE['darkMode'];?>">
    
    <?php 
       
        include(__DIR__ . '/../includes/tool-bar.php')

    ?>

    <div id="container">

        <div id="feed">
            <?php
                include(__DIR__ . '/../../app/php/showPosts.php');

                $query = 'SELECT DISTINCT id_user FROM users INNER JOIN posts ON fk_owner = id_user';

                $stmt = $conn-> query($query);

                $return = $stmt -> fetchAll();

                foreach ($return as $user) {

                    showPosts($conn, $user['id_user'] , 10);

                }

                echo'<div class="post text">
                    No more posts from this site to show!
                    </div>';

            ?>
        </div>
    </div>

    <?php 
        
        include(__DIR__ . '../includes/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>

</body>
</html>