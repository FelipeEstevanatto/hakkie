<?php
    
    if (!isset($_SESSION['isAuth'])) {
        header("Location: ../home.php ");
	    exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undefined User</title>

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
<body class="<?=$_COOKIE['darkMode'];?>">
    
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

                <h2 class="name">This user does not exist!</h2>
            </div>
         </div>


        <div class="undefined">
            <i class="fas fa-frown-open"></i>
            <span>
                This user does not exist, why are you here!
            </span>
        </div>
    </div>

    <?php 

        include('message.html')

    ?>
</body>
</html>