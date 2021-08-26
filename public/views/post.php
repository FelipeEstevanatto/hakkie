<?php
    session_start();

    if (!isset($_SESSION['isAuth'])) {

        if (isset($_GET["id"])) {
            setcookie("resumeP", $_GET["id"], time()+3600, "/");
        }

        header("Location: login.php");
	    exit();
    }

    require("../../app/database/connect.php");
    require_once("../../app/php/functions.php");

    if ( !isset($_GET['id']) || is_numeric($_GET['id']) || is_float(decodeId($_GET['id']))) {
        include("../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();      
    }

    $post = decodeId($_GET['id']);

    $query = "SELECT user_blocked FROM blocks WHERE fk_user = :id_user";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $post);
    $stmt -> execute();

    if ($stmt -> rowCount() > 0) {
        include("../includes/user-blocked.php"); //This user does not exist in DB! (we don't have blocked page yet)
        exit();
    }

    $query = "SELECT id_user FROM users INNER JOIN posts ON fk_owner = id_user WHERE id_post = :id_post";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_post', $post);
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    $id_user = $return['id_user'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - <?='aaa'?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="../css/home/grid/grid.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="../css/home/feed/feed.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?=$_COOKIE['darkMode'];?>">
    
    <?php 

        include('../includes/tool-bar.php');

    ?>

    <div id="container">
        <div id="feed">
            <?php
                include('../../app/php/showPosts.php');

                showPosts( $id_user , 1 , $_GET['id']);

            ?>
        </div>
    </div>

    <?php 

        include('../includes/message.html')

    ?>

    <script type="text/javascript" src="../../js/functions.js"></script>
    <script type="text/javascript"src="../../js/feedbuild.js"></script>

</body>
</html>