<?php
    
    
    if(!isset($_SESSION['isAuth'])){
        header("Location: home ");
	    exit();
    }

    require(__DIR__."/../../bootstrap.php");
    require_once(__DIR__."/../../app/php/functions.php");

    if ( !isset($_GET['user']) || is_numeric($_GET['user']) || is_float(decodeId($_GET['user']))) {
        include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();
    } else {

        $GET_user = decodeId(filter_var($_GET['user'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if ($_GET['user'] == $_SESSION['idUser']) {
            $himself = true;
        }
    }

    $query = "SELECT username, user_info, picture, banner, created_at, auth_type, darkmode 
              FROM users WHERE id = :id";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id', $GET_user, PDO::PARAM_INT);

    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    if ($stmt -> rowCount() < 1) {
        include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();
    }

    $isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;
    
    $user_name = $return['username'];
    $picture = $return['picture'];
    $banner = $return['banner'];
    $user_info = $return['user_info'];

    $query = "SELECT user_followed, follow_date, fk_user FROM follows WHERE user_followed = :id ORDER BY follow_date";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', $GET_user);
    $stmt -> execute();
    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $followers = count($return);

    $query = "SELECT user_followed, follow_date, fk_user, username, picture, user_info, auth_type FROM follows 
              INNER JOIN users ON id = user_followed WHERE fk_user = :id ORDER BY follow_date";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', $GET_user);
    $stmt -> execute();
    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $following = count($data);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/../css/home/grid/grid.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/../css/style.css">
    <link rel="stylesheet" href="../css/followers/followers.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?=$_COOKIE['darkMode'];?>">
    
    <?php 

        include(__DIR__.'/../includes/tool-bar.php')

    ?>

    <div id="container">

        <div class="top">
            <?php
                if ($isGoogle) {
                    echo '<img class="profile-picture" src="'.$picture.'" alt="Picture of user">';
                } elseif (!is_null($picture)) {
                    echo '<img class="profile-picture" src="../images/defaultUser.png" alt="Picture of user">';
                } else { //fallback
                    echo '<img class="profile-picture" src="../images/defaultUser.png">';
                }
            ?>

            <a href="user=<?=encodeId($GET_user)?>"><?=$user_name?></a>
         </div>

         <div class="tab-list">
            <a href="following=<?=encodeId($GET_user)?>" class="tab">
                (<?=$following?>) Following
                <div class="underline"></div>
            </a>
            <a href="followers=<?=encodeId($GET_user)?>" class="tab">
                (<?=$followers?>) Followers
            </a>
        </div>

         <div id="feed">
             <!--Follow layout-->
            <?php
                foreach ($data as $users) {
                    $each_user ='
                    <div class="user-box">
                        <div class="box-top">
                            <div class="info">
                                <img src="';
                                if ($users['auth_type'] == 'GOOGLE') {
                                    $each_user .= $users['picture'];
                                } elseif (!is_null($picture)) {
                                    $each_user .= '../images/'.$users['picture'];
                                } else { 
                                    $each_user .= '../images/defaultUser.png'; // Fallback
                                }
                        $each_user .='" alt="Picture of user">
                                <a href="user?user='.encodeId($users['user_followed']).'">'.$users['username'].'</a>
                            </div>
                            
                            <div class="btn follow">
                                <i class="fas fa-user-plus"></i>
                                <a href="user?user='.encodeId($users['fk_user']).'"><span>Follow</span></a>
                            </div>
                        </div>

                        <div class="box-date">
                            <span>Following since: '.str_replace('-','/',substr($users['follow_date'],0,10)).'</span>
                        </div>

                        <div class="box-about">';
                        if (!is_null($users['user_info']))
                            $each_user .= $users['user_info'];
                        $each_user .='
                        </div>

                        <div class="btn-responsive">
                            <i class="fas fa-user-plus"></i>
                            <span>Follow</span>
                        </div>
                    </div>
                    ';
                    echo$each_user;
                }
            ?>
            
         </div>
    </div>

    <?php 

        include(__DIR__.'/../includes/message.php')

    ?>
    
</body>
</html>