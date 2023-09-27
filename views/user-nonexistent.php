<?php
    
    require('partials/header.php');
    include('partials/tool-bar.php');

?>

    <div id="container">

    <div class="top">
            <div class="banner">
                <img src="<?= $GLOBALS['base_url'] ?>/../public/images/defaultBanner.jpg" alt="Banner of user">
            </div>

            <div class="info">
                <img class="profile-picture" src="<?= $GLOBALS['base_url'] ?>/../public/images/defaultUser.png" alt="Picture of user">

                <div class="clear"></div>

                <h2 class="name">This user does not exist!</h2>
            </div>
         </div>


        <div class="undefined">
            <i class="fas fa-frown-open"></i>
            <span>
                This user does not exist, why are you here!
            </span>
        </div>
    </div>

<?php 

    include(__DIR__.'/message.php');
    require('partials/footer.php');
?>