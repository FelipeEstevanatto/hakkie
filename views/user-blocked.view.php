<?php

    require('partials/header.php');
    include('partials/tool-bar.php');

?>

    <div class="flex justify-center bg-almost-black text-white min-h-screen relative">
        <div class="w-1/2">
            <div class="banner">
                <img src="../images/defaultBanner.jpg" alt="Banner of user">
            </div>

            <div class="info">
                <img class="profile-picture" src="<?= $GLOBALS['base_url'] ?>/../public/images/defaultUser.png" alt="Picture of user">

                <div class="clear"></div>
                <?php 
                    if ($details == 'own_block') {
                        echo'<h2 class="name">You blocked this user!</h2>';
                    } else {
                        echo'<h2 class="name">This user has blocked you!</h2>';
                    }
                ?>
            </div>
         </div>


        <div class="undefined">
            <i class="fas fa-frown-open"></i>
            <span>
                <?php 
                    if ($details == 'own_block') {
                        echo'You blocked this user! If that was a mistake, go to the <a href="settings">settings page</a> and unblock him';
                    } else {
                        echo'Unfortunately this user has blocked you, but you can go to the <a href="settings">settings page</a> and unblock him';
                    }
                ?>
            </span>
        </div>
    </div>

<?php 

    include('partials/message.php');
    require('partials/footer.php');

?>