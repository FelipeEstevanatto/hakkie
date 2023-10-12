<?php
    

    // if (!isset($_SESSION['isAuth'])) {

    //     if (isset($_GET["id"])) {
    //         setcookie("resumeP", $_GET["id"], time()+3600, "/");
    //     }

    //     header("Location: login.php");
	//     exit();
    // }

    require_once(__DIR__. "/../../bootstrap.php");
    require_once(__DIR__. "/../../app/php/functions.php");

    if ( !isset($_GET['id']) || is_numeric($_GET['id']) || is_float(decodeId($_GET['id']))) {
        include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
        exit();      
    }

    $post = decodeId($_GET['id']);

    $query = "SELECT user_blocked FROM blocks WHERE fk_user = :id";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', $post);
    $stmt -> execute();

    if ($stmt -> rowCount() > 0) {
        include(__DIR__."/../includes/user-blocked.php"); //This user does not exist in DB! (we don't have blocked page yet)
        exit();
    }

    $query = "SELECT id FROM users INNER JOIN posts ON fk_owner = id WHERE id = :id";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', $post);
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);
    $id = $return['id'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - <?='aaa'?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/../public/css/home/grid/grid.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/../public/css/style.css">

    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>/../public/css/home/feed/feed.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?=$_COOKIE['darkMode'];?>">
    
    <?php 

        include(__DIR__.'/../includes/tool-bar.php');

    ?>

    <div id="container">
        <div id="feed">
            <?php
                include(__DIR__.'/../../app/php/showPosts.php');

                showPosts($conn, $id, 1, $_GET['id']);

            ?>
        </div>
    </div>

    <?php 

        include(__DIR__.'/../includes/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript"src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>

</body>
</html>