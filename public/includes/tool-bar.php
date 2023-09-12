
<div id="tool-bar">
    <div class="logo">
        Hakkie
    </div>

    <?php

    if (isset($_SESSION['isAuth']) && $_SESSION['isAuth']) {
        $logged = true;
        $user_profile = "user?user=".$_SESSION['idUser'];
    } else {
        $user_profile = "login";
        $logged = false;
    }
        
    ?>

    <div class="buttons">
        <a href="home" class="btn">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <?php if ($logged) {?>
        <a href="notifications" class="btn">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
        </a>
    
        <a href="<?php echo $user_profile; ?>" class="btn">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>

        <a href="settings" class="btn">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <?php } ?>
    </div>  
</div>