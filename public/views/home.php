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
        <a href="user.php?user=<?=1?>">Gabriel</a>
        <a href="user.php?user=<?=2?>">Felipolas</a>
    </div>

    <?php 

        include('../includes/message.html')

    ?>
</body>
</html>