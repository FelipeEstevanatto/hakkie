<?php

    if (!isset($_SESSION['isAuth'])) {
        header("Location: ../home.php ");
	    exit();
    }

    require("../../app/database/connect.php");

    $query = "SELECT user_blocked FROM blocks WHERE fk_user = :id_user";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', 1);
    $stmt -> execute();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User page</title>

    <!-- Styles -->
    <link rel="stylesheet" href="../css/home/grid/grid.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/home/user-nonexistent.css">
    <link rel="stylesheet" href="../css/user/user.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?= $_SESSION['darkMode'];?>">
    
    <?php 

        include('tool-bar.php')

    ?>

    <div id="container">

    <div class="top">
            <div class="banner">
                <img src="../images/defaultBanner.jpg" alt="Banner of user">
            </div>

            <div class="info">
                <img class="profile-picture" src="../images/defaultUser.png" alt="Picture of user">

                <div class="clear"></div>
                <?php 
                    if ($details == 'own_block') {
                        echo'<h2 class="name">You blocked this user!</h2>';
                    } else {
                        echo'<h2 class="name">This user has blocked you!</h2>';
                    }
                ?>
            </div>
         </div>


        <div class="undefined">
            <i class="fas fa-frown-open"></i>
            <span>
                <?php 
                    if ($details == 'own_block') {
                        echo'You blocked this user! If that was a mistake, go to the <a href="../views/settings.php">settings page</a> and unblock him';
                    } else {
                        echo'Unfortunately this user has blocked you, but you can go to the <a href="../views/settings.php">settings page</a> and unblock him';
                    }
                ?>
            </span>
        </div>
    </div>

    <?php 

        include('message.html')

    ?>
</body>
</html>