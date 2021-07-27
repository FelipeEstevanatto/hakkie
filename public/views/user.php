<?php
    session_start();
    
    if(!isset($_SESSION['isAuth'])){
        header("Location: home.php ");
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
    <link rel="stylesheet" href="../css/user/user.css">

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
         <div class="top">
             <div class="banner">

             </div>

             <div class="info">
                <img class="profile-picture" src="https://avatars.githubusercontent.com/u/69210720?s=400&u=e29d62deef9aa07ca86119bb288840449b81a57b&v=4">

                <div class="time">
                    <i class="fas fa-calendar-alt"></i>
                    Joined February 2019
                </div>

                <div class="clear"></div>

                <h2 class="name">Gabriel Gomes Nicolim</h2>

                <p class="description">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto, sint expedita assumenda non quos et eiu
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto, sint expedita assumenda non quos et eiu
                </p>

                <div class="bottom-bar">
                    <div class="left">
                        <a href="#">
                            <span>9</span>
                            Following
                        </a>

                        <a href="#">
                            <span>9</span> 
                            Followers
                        </a>
                    </div>

                    <div class="right">
                        <div class="btn follow" id="interact-btn">
                            <i class="fas fa-user-plus"></i>
                            <span>Follow</span>
                        </div>

                        <div class="btn">
                            <i class="fas fa-comment-dots"></i>
                        </div>

                        <div class="btn">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>
            </div>
         </div>

         <div class="feed">

         </div>
    </div>

    <?php 

        include('../includes/message.html')

    ?>

    <script src="../../js/followUser.js"></script>
</body>
</html>