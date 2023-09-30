<?php
    
    require('partials/header.php');
    include('partials/tool-bar.php');

?>

<div class="flex justify-center bg-almost-black text-white min-h-screen border-x-2 border-slate-500 p-8 relative">
    <div class="w-1/2">
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

    include('partials/message.php');
    require('partials/footer.php');
?>