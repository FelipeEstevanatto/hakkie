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
    } else {

        $GET_user = filter_var($_GET['user'], FILTER_VALIDATE_INT);

        if ($_GET['user'] == $_SESSION['idUser']) {
            $himself = true;
        }

    } 

    $query = "SELECT name_user, user_info, user_picture, created_at, auth_type, darkmode FROM users WHERE id_user = :id_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', $GET_user);

    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    
    if ($stmt -> rowCount() < 1) {
        include("../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();
    }

    if ($return['auth_type'] == "GOOGLE") {
        $isGoogle = true;
    } else {
        $isGoogle = false;
    }
    
    $user_name = $return['name_user'];
    $user_picture = $return['user_picture'];
    $user_info = $return['user_info'];

    $query = 'SELECT user_followed, follow_date, fk_user, name_user, user_picture, user_info, auth_type FROM follows 
              INNER JOIN users ON id_user = fk_user WHERE user_followed = :id_user ORDER BY follow_date';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $GET_user);
    $stmt -> execute();
    $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $followers = count($data);

    $query = "SELECT user_followed, follow_date, fk_user FROM follows WHERE fk_user = :id_user ORDER BY follow_date";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $GET_user);
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

        include('../includes/tool-bar.php');

        if (!$isGoogle) {
            if (!is_null($user_picture)) {
                $user_picture = '../images/defaultUser.png';
            } else { //fallback
                $user_picture = '../images/defaultUser.png';
            }
        }
    ?>

    <div id="container">

        <div class="top">
            <img class="profile-picture" src="<?=$user_picture?>" alt="Picture of user">
            <a href="user.php?user=<?=$GET_user?>"><?=$user_name?></a>
         </div>

        <div class="tab-list">
            <a href="following.php?user=<?=$GET_user?>" class="tab">
                (<?=$following?>) Following
            </a>
            <a href="followers.php?user=<?=$GET_user?>" class="tab">
                (<?=$followers?>) Followers
                <div class="underline"></div>
            </a>
        </div>

         <div id="feed">
            <?php
                foreach ($data as $users) {
                    $each_user = '
                            <div class="user-box">
                        <div class="box-top">
                            <div class="info">
                                <img src="';
                                if ($users['auth_type'] == 'GOOGLE') {
                                    $each_user .= $users['user_picture'];
                                } elseif (!is_null($user_picture)) {
                                    $each_user .= '../images/'.$users['user_picture'].'.png';
                                } else { //fallback
                                    $each_user .= '../images/defaultUser.png';
                                }
                        $each_user .='" alt="Picture of user">
                                <a href="user.php?user='.$users['fk_user'].'">'.$users['name_user'].'</a>
                            </div>
                            
                            <div class="btn follow">
                                <i class="fas fa-user-plus"></i>
                                <a href="user.php?user='.$users['fk_user'].'"><span>Follow</span></a>
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

            <!--Follow layout
            <div class="user-box">
                <div class="box-top">
                    <div class="info">
                        <img src="https://avatars.githubusercontent.com/u/69210720?s=400&u=e29d62deef9aa07ca86119bb288840449b81a57b&v=4">

                        <a href="">Gabriel Gomes Nicolim</a>
                    </div>
                    
                    <div class="btn follow">
                        <i class="fas fa-user-plus"></i>
                        <span>Follow</span>
                    </div>
                </div>

                <div class="box-date">
                    <span>Seguindo desde: 04/08/2021</span>
                </div>

                <div class="box-about">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit esse nam voluptate, impedit minima reprehenderit itaque laboriosam dolore distinctio consectetur deleniti aliquam eos consequatur dolorem aspernatur! Fugit aut officia recusandae.
                </div>

                <div class="btn-responsive">
                    <i class="fas fa-user-plus"></i>
                    <span>Follow</span>
                </div>
            </div>-->
            
         </div>
    </div>

    <?php 

        include('../includes/message.html')

    ?>

</body>
</html>