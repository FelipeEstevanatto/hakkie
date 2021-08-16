<?php

    if (!isset($_SESSION['isAuth'])) {
        header("Location: ../home.php ");
	    exit();
    }
?>

<div id="tool-bar">
    <div class="logo">
        Hakkie
    </div>

    <?php

    if (isset($_SESSION['isAuth']) && $_SESSION['isAuth']) {
        $logged = true;
        $user_profile = "user.php?user=".$_SESSION['idUser'];
    } else {
        $user_profile = "login.php";
        $logged = false;
    }
        
    ?>

    <div class="buttons">
        <a href="home.php" class="btn">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <?php if ($logged) {?>
        <a href="notifications.php" class="btn">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
        </a>
    
        <a href="<?=$user_profile?>" class="btn">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>

        <a href="settings.php" class="btn">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <?php } ?>
    </div>  
</div>