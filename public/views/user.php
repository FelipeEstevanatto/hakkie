<?php
    session_start();
    
    if(!isset($_SESSION['isAuth'])){
        header("Location: home.php ");
	    exit();
    }

    require("../../app/database/connect.php");
    if ( !isset($_GET['user']) && !is_numeric($_GET['user'])) {
        //deu merda
        exit();
    }

    $query = "SELECT name_user, user_info, user_picture, user_banner, created_at, darkmode FROM users WHERE id_user = :id_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', $_GET['user']);

    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    $time = substr($return['created_at'], 5, 2);   
    $months = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    ];

    $user_since = $months[$time]." of ".substr($return['created_at'], 0, 4);
    
    $user_name = $return['name_user'];
    $user_picture = $return['user_picture'];
    $user_banner = $return['user_banner'];
    $user_info = $return['user_info'];
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
                <?php 
                    if (is_null($user_banner)) {
                        echo '<img src="../images/defaultBanner.png">';
                    } else {
                        echo '<img src="../images/'.$user_banner.'">';
                    }
                ?>
            </div>

            <div class="info">
                    <?php 
                        if (!is_null($user_picture)) {
                            echo '<img class="profile-picture" src="../images/defaultUser.png">';
                        } else { //fallback
                            echo '<img class="profile-picture" src="../images/defaultUser.png">';
                        }
                    ?>

                <div class="time">
                    <i class="fas fa-calendar-alt"></i>
                    Joined <?=$user_since?>
                </div>

                <div class="clear"></div>

                <h2 class="name"><?=$user_name?></h2>

                <p class="description">
                    <?php 
                        if (!is_null($user_info)) {
                            echo $user_info;
                        } 
                    ?>
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