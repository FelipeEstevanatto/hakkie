<?php

    require('partials/header.php');
    include('partials/tool-bar.php');
    include('partials/no-script.php');
    
?>
<div class="flex justify-center bg-almost-black text-white min-h-screen relative">
    <div class="w-screen lg:w-1/2">
        <div class="top relative">
            <div class="banner w-full h-96">
                <img src="<?= $GLOBALS['base_url'] . "/../public/images/" ?><?= is_null($banner) ? "defaultBanner.jpg" : $banner ?>" alt="Banner of user" class="w-full h-full">
            </div>
    
            <div class="info p-4">
                <img class="profile-picture absolute rounded-full h-72 w-72 top-52 border-4 border-stone-500" src="<?= is_null($picture) ? $GLOBALS['base_url']."/../public/images/defaultUser.png" : "$picture" ?>" alt="Picture of user">
                <div class="time text-right text-gray-400">
                    <i class="fas fa-calendar-alt"></i>
                    Joined <?=$user_since?>
                </div>
    
                <div class="clear h-20"></div>
    
                <h2 class="name font-bold text-2xl"><?=$user_name?></h2>
    
                <p class="description text-justify break-words my-4 text-gray-200">
                    <?=!is_null($user_info) ? $user_info : 'Nothing to say.';?>
                </p>
                <h2 class="name text-4xl text-center"><?= $own_block ? 'You blocked this user' : 'This user has blocked you' ?> !</h2>
                
            </div>
        </div>


        <div class="undefined text-center break-words my-4 text-gray-200 text-2xl p-4">
            <i class="fas fa-frown-open"></i>
            <span>
                <?php 
                    if ($own_block) {
                        echo'You blocked this user! If that was a mistake, go to the <a href="settings">settings page</a> and unblock him';
                    } else {
                        echo'Unfortunately this user has blocked you, life do be like that sometimes.';
                    }
                ?>
            </span>
        </div>
    </div>
</div>
<?php 

    include('partials/message.php');
    require('partials/footer.php');

?>