<!DOCTYPE html>
<?php
    
    
    if(!isset($_SESSION['isAuth'])){

        if (isset($_GET["user"])) {
            setcookie("resumeU", $_GET["user"], time()+3600, "/");
        }

        header("Location: home ");
	    exit();
    }

    require(__DIR__ . "/../../bootstrap.php");
    require_once(__DIR__ ."/../../app/php/functions.php");

    if ( !isset($_GET['user']) || !is_numeric(decodeId($_GET['user'])) || is_numeric($_GET['user']) || is_float(decodeId($_GET['user'])) ) {
        include(__DIR__ . "/../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();    
    } elseif (decodeId($_GET['user']) == decodeId($_SESSION['idUser'])){
        $own_profile = true;
    } else {
        $own_profile = false;
        
        $query = "SELECT user_blocked, fk_user FROM blocks WHERE fk_user = :id OR user_blocked = :id";

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));

        $stmt -> execute();

        if ($stmt -> rowCount() > 0) {

            $details = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($details['fk_user'] == decodeId($_SESSION['idUser'])) {
                $details = 'own_block';
            }

            include(__DIR__."/../includes/user-blocked.php"); //This user does not exist in DB! (we don't have blocked page yet)
            exit();
        }

    }

    $query = "SELECT username, user_info, picture, banner, created_at, darkmode, auth_type 
              FROM users WHERE id = :id";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', decodeId($_GET['user']) );
    $stmt -> execute();
    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($stmt -> rowCount() < 1) {
        include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();
    }

    $user_since = joinedSince($return['created_at']);
    
    $isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;
    
    $user_name = $return['username'];
    $picture = $return['picture'];
    $banner = $return['banner'];
    $user_info = $return['user_info'];

    // Get followers, following number and if SESSION is following 
    $query = 'SELECT 
                COUNT(CASE WHEN user_followed = :id THEN 1 END) AS followers,
                COUNT(CASE WHEN fk_user = :id THEN 1 END) AS followings,
                EXISTS (SELECT user_followed FROM follows WHERE fk_user = :fk_user AND 
                fk_user IS NOT NULL AND fk_user != :id ) AS isfollowing
              FROM follows;';

    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', decodeId($_GET['user']));
    $stmt -> bindValue(':id', decodeId($_GET['user']));
    $stmt -> bindValue(':fk_user', decodeId($_SESSION['idUser']));
    $stmt -> bindValue(':id', decodeId($_GET['user']));
    $stmt -> execute();
 
    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
 
    $followers = $return['followers'];
    $following = $return['followings'];
    $follow_status = $return['isfollowing'] ? 'unfollow' : 'follow';

?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User <?=$user_name?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/public/css/home/grid/grid.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/public/css/user/user.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/public/css/home/feed/feed.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?=$_COOKIE['darkMode'];?>">
    
    <?php

        include(__DIR__ . '/../includes/no-script.php');
        include(__DIR__ . '/../includes/tool-bar.php');

    ?>

    <div id="container">

        <div class="top">
            <div class="banner">
                <img src="<?= $GLOBALS['base_url'] . "/../public/images/" ?><?= is_null($banner) ? "defaultBanner.jpg" : $banner ?>" alt="Banner of user">
            </div>

            <div class="info">
                <img class="profile-picture" src="<?= is_null($picture) ? $GLOBALS['base_url']."/../public/images/defaultUser.png" : "$picture" ?>" alt="Picture of user">
                <div class="time">
                    <i class="fas fa-calendar-alt"></i>
                    Joined <?=$user_since?>
                </div>

                <div class="clear"></div>

                <h2 class="name"><?=$user_name?></h2>

                <p class="description">
                    <?php
                        echo !is_null($user_info) ? $user_info : 'Nothing to say.';
                    ?>
                </p>

                <div class="bottom-bar">
                    <div class="left">
                        <a href="following?user=<?=$_GET['user']?>">
                            <span id="following"><?=$following?></span>
                            Following
                        </a>

                        <a href="followers?user=<?=$_GET['user']?>">
                            <span id="followers"><?=$followers?></span>
                            Followers
                        </a>
                    </div>

                    <div class="right">
                        <?php 
                        
                            if (!$own_profile) {
                                echo'<div class="btn '.$follow_status.'" id="interact-btn">';
                                if ($follow_status == 'Follow') {
                                    echo '<i class="fas fa-user-plus"></i>';
                                } else
                                    echo'<i class="fas fa-user-times"></i>';
                                    echo'<span> '.$follow_status.'</span>
                                    </div>';
                            } 
                  
                        ?>

                        <div class="btn" id="direct_message">
                            <i class="fas fa-comment-dots"></i>
                        </div>

                        <div id="ellipsis-modal" class="close">
                        <?php 

                            if (!$own_profile) {
                            echo '<div class="btn" id="silence_user">Silence User</div>
                                  <div class="btn" id="block_user">Block User</div>';
                            } else {
                                echo '<a href="settings"><div class="btn" id="edit_user">Edit User</div></a>';
                            }

                        ?>
                            <div class="btn" id="link_user">Copy Profile Link</div>
                        </div>

                        <div id="ellipsis" class="btn">
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                    </div>
                </div>
            </div>
         </div>

        <div class="tab-list">
            <div class="tab">
                Posts
                <div class="underline"></div>
            </div>
            <div class="tab">
                Media
                <div class=""></div>
            </div>
            <div class="tab">
                Likes
                <div class=""></div>
            </div>
        </div>

        <?php 
            if ($own_profile) {
        ?>

        <div class="post-input">
            <h2>Post</h2>
            <form action="postLogic" method="POST" enctype='multipart/form-data'>
                <textarea name="post-text" id="textarea" maxlength="256" cols="30" rows="10" placeholder="What is going on?"></textarea>
                <label id="count" for="post-text"></label>

                <div id="images-preview"></div>
                    
                <input type='file' id="uploadfile" name='uploadfile[]' accept='.png,.PNG,.JPG,.jpg,.JPEG,.webpm,.mp4,.mov,.gif' multiple style='display:none;' @change="trySubmitFile"/>
                <label id="uploadfile-label" for="uploadfile">
                    <span><i class="fas fa-upload"></i></span>     
                </label>
                <input type="submit" value="Submit">
            </form>
        </div>
        <script>
        function trySubmitFile(e) {
            if (this.disabled) return;
            const files = e.target.files || e.dataTransfer.files;
            if (files.length > 4) {
                alert('You are only allowed to upload a maximum of 2 files at a time');
            }
            if (!files.length) return;
            for (let i = 0; i < Math.min(files.length, 2); i++) {
                this.fileCallback(files[i]);
            }
        }
      </script>
        <?php
        }
        ?>
    
        <div id="feed">        
            <?php
                include(__DIR__ . "/../../app/php/showPosts.php");

                // Post layout
                showPosts($conn, decodeId($_GET['user']), 10);

                echo'<div class="post text">
                No more posts from this user to show!
                </div>';
            ?>
 
        </div>
    </div>

    <?php 

        include(__DIR__ . '/../includes/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/openMenu.js"></script>   

    <?php 
        if (!$own_profile) {   
            echo "<script src=\"".$GLOBALS['base_url']."/js/followUser.js\"></script>";         
        } else {
            echo "<script src=\"".$GLOBALS['base_url']."/js/imagePreview.js\"></script>";         
    ?>

    <script src="<?= $GLOBALS['base_url'] ?>/js/letterCount.js">
        letterCount(140, 'post-text', 'post-count')
    </script>

    <?php } ?>
</body>
</html>