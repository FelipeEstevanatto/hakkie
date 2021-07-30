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
    } elseif ($_GET['user'] != $_SESSION['idUser']) {

        $query = "SELECT user_blocked FROM blocks WHERE fk_user = :id_user";

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':id_user', $_SESSION['idUser']);

        $stmt -> execute();

        if ($stmt -> rowCount() > 0) {
            include("../includes/user-nonexistent.php"); //This user does not exist in DB!
            exit();
        }

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

    $query = "SELECT user_followed FROM follows WHERE user_followed = :id_user ORDER BY follow_date";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $_GET['user']);
    $stmt -> execute();
    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $followers = count($return);

    $query = "SELECT user_followed FROM follows WHERE fk_user = :id_user ORDER BY follow_date";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $_GET['user']);
    $stmt -> execute();
    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $following = count($return);

    $query = "SELECT user_followed FROM follows WHERE fk_user = :id_user";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);
    $stmt -> execute();
    $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt -> rowCount() == 0) {
        $follow_status = 'follow';
    } else {
        $follow_status = 'unfollow';
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

        <div class="top">
            <div class="banner">
                <?php 
                    if (is_null($user_banner)) {
                        echo '<img src="../images/defaultBanner.jpg" alt="Banner of user">';
                    } else {
                        echo '<img src="../images/'.$user_banner.'">';
                    }
                ?>
            </div>

            <div class="info">
                    <?php 
                        if (!is_null($user_picture)) {
                            echo '<img class="profile-picture" src="../images/defaultUser.png" alt="Picture of user">';
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
                        <a href="following.php?user=<?=$_GET['user']?>">
                            <span id="following"><?=$following?></span>
                            Following
                        </a>

                        <a href="followers.php?user=<?=$_GET['user']?>">
                            <span id="followers"><?=$followers?></span>
                            Followers
                        </a>
                    </div>

                    <div class="right">
                        <?php 
                        
                            if ($_GET['user'] != $_SESSION['idUser']) {
                                echo '<div class="btn '.$follow_status.'" id="interact-btn">';
                                    echo '<i class="fas fa-user-plus"></i>';
                                    echo '<span> '.$follow_status.'</span>';
                                echo '</div>';
                            } 
                  
                        ?>

                        <div class="btn">
                            <i class="fas fa-comment-dots"></i>
                        </div>

                        <div id="ellipsis-modal" class="close">

                            <?php 

                            if ($_GET['user'] != $_SESSION['idUser']) {

                            echo '<div class="btn" id="silence_user">Silence User</div>';
                            echo '<div class="btn" id="block_user">Block User</div>';

                            } else {
                                echo '<a href="settings.php"><div class="btn" id="edit_user">Edit User</div></a>';
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
            if ($_GET['user'] == $_SESSION['idUser']) {
        ?>

        <div class="post-input">
            <h2>Post</h2>
            <form action="../../app/php/postLogic.php" method="POST" enctype='multipart/form-data'>
                <textarea name="post-text" id="textarea" maxlength="256" cols="30" rows="10" placeholder="What is going on?"></textarea>
                <label id="count" for="post-text"></label>

                <div id="images-preview"></div>
                    
                <input type='file' id="uploadfile" name='uploadfile' accept='.png,.PNG,.JPG,.jpg,.JPEG,.webpm,.mp4,.mov,.gif' multiple style='display:none;'/>
                <label id="uploadfile-label" for="uploadfile">
                    <span><i class="fas fa-upload"></i></span>     
                </label>

                <input type="submit" value="Submit">
            </form>
        </div>

        <?php
        }
        ?>
    
         <div id="feed">
            <?php
                include("../../app/php/showPosts.php");

                showPosts($_GET['user'], 10, 'posts');
            ?>
            <!--Post layout-->
            <div class="post text">
                <div class="top-post">
                    <div class="left">
                        <img src="../images/defaultUser.png">
                        <a href="#">Gabriel Gomes Nicolim</a>
                    </div>
                    
                    <div class="right">
                        <span>28/07/2021</span>
                    </div>
                </div>
                <div class="content-post">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis veritatis natus voluptatum rem alias odit vel consequatur dignissimos? In eius alias velit, maiores nulla modi sit repellendus iure dolorem sunt?
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Iusto id veniam, distinctio quae consequatur tempora iste maiores totam, corrupti impedit iure laboriosam reiciendis fuga nam perspiciatis sint, deserunt consectetur recusandae.
                </div>
                <div class="bottom-post">
                    <div class="list">
                        <div class="tab">
                            <i class="fas fa-thumbs-up"></i>
                            <span>Like</span>
                        </div>
                        <div class="tab">
                            <i class="fas fa-comment"></i>
                            <span>Comment</span>
                        </div>
                        <div class="tab">
                            <i class="fas fa-share-square"></i>
                            <span>Share</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Post layout-->
            <div class="post text">
                <div class="top-post">
                    <div class="left">
                        <img src="../images/defaultUser.png">
                        <a href="#">Gabriel Gomes Nicolim</a>
                    </div>
                    
                    <div class="right">
                        <span>28/07/2021</span>
                    </div>
                </div>
                <div class="content-post">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis veritatis natus voluptatum rem alias odit vel consequatur dignissimos? In eius alias velit, maiores nulla modi sit repellendus iure dolorem sunt?
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Iusto id veniam, distinctio quae consequatur tempora iste maiores totam, corrupti impedit iure laboriosam reiciendis fuga nam perspiciatis sint, deserunt consectetur recusandae.
                </div>
                <div class="bottom-post">
                    <div class="list">
                        <div class="tab">
                            <i class="fas fa-thumbs-up"></i>
                            <span>Like</span>
                        </div>
                        <div class="tab">
                            <i class="fas fa-comment"></i>
                            <span>Comment</span>
                        </div>
                        <div class="tab">
                            <i class="fas fa-share-square"></i>
                            <span>Share</span>
                        </div>
                    </div>
                </div>
            </div>   
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
    <script src="../../js/imagePreview.js"></script>

    <?php 
        if ($_GET['user'] == $_SESSION['idUser']) {
    ?>

    <script src="../../js/letterCount.js">
        letterCount(140, 'post-text', 'post-count')
    </script>

    <?php } ?>
</body>
</html>