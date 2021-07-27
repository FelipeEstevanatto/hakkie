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

        include('../includes/tool-bar.html')

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
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto, sint expedita assumenda non quos et eius tenetur harum nobis beatae vel id ad exercitationem nesciunt corrupti repellat maxime cum. Magnam.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti nemo nesciunt accusantium quaerat accusamus voluptatum ab quae nihil necessitatibus. Voluptatum adipisci qui alias deserunt ipsum voluptate sint ut a iusto!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio non, dolor delectus ipsam omnis vitae quas, ipsa sequi blanditiis natus culpa asperiores consequuntur, optio amet similique? Asperiores possimus quo nemo.
                </p>

                <div class="follow">
                    <a href="#">
                        <span>9</span>
                        Following
                    </a>

                    <a href="#">
                        <span>9</span> 
                        Followers
                    </a>
                </div>
            </div>
         </div>

         <div class="feed">

         </div>
    </div>

    <?php 

        include('../includes/message.html')

    ?>
</body>
</html>