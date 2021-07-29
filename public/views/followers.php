<?php
    session_start();
    
    if(!isset($_SESSION['isAuth'])){
        header("Location: home.php ");
	    exit();
    }

    require("../../app/database/connect.php");
    if ( !isset($_GET['user']) || !is_numeric($_GET['user'])) {
        include("../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();
    } elseif ($_GET['user'] == $_SESSION['idUser']) {
        $himself = true;
    }

    $query = "SELECT name_user, user_info, user_picture, user_banner, created_at, darkmode FROM users WHERE id_user = :id_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', $_GET['user']);

    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    if ($stmt -> rowCount() < 1) {
        include("../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();
    }
    
    $user_name = $return['name_user'];
    $user_picture = $return['user_picture'];
    $user_banner = $return['user_banner'];
    $user_info = $return['user_info'];

    $query = "SELECT user_followed, follow_date, fk_user FROM follows WHERE user_followed = :id_user ORDER BY follow_date";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $_GET['user']);
    $stmt -> execute();
    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $followers = count($return);

    $query = "SELECT user_followed, follow_date, fk_user FROM follows WHERE fk_user = :id_user ORDER BY follow_date";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $_GET['user']);
    $stmt -> execute();
    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $following = count($return);

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
    <link rel="stylesheet" href="../css/followers/followers.css">

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
            <?php 
                if (!is_null($user_picture)) {
                    echo '<img class="profile-picture" src="../images/defaultUser.png" alt="Picture of user">';
                } else { //fallback
                    echo '<img class="profile-picture" src="../images/defaultUser.png">';
                }
            ?>

            <a href="user.php?user=<?=$_GET['user']?>"><?=$user_name?></a>
         </div>

        <div class="tab-list">
            <div class="tab">
                Followers
                <div class="underline"></div>
            </div>
            <div class="tab">
                Following
                <div class=""></div>
            </div>
        </div>

         <div id="feed">
            <?php
                //Request posts
            ?>
            <!--Follow layout-->
            
         </div>
    </div>

    <?php 

        include('../includes/message.html')

    ?>

    <?php 
        if ($_GET['user'] != $_SESSION['idUser']) {
            echo '<script src="../../js/followUser.js"></script>';
        }
    ?>

    <script src="../../js/feedbuild.js"></script>
    <script src="../../js/openMenu.js"></script>
</body>
</html>