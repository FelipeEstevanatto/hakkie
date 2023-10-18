<?php
    
    require('partials/header.php');
    include('partials/tool-bar.php');
    include('partials/no-script.php');

?>

<div class="flex justify-center bg-gray-200 dark:bg-almost-black text-white min-h-screen relative">
    <div class="w-1/2">
        <div class="relative">
            <div class="banner banner w-full h-96">
            <img src="<?= $GLOBALS['base_url'] ?>/../public/images/defaultBanner.jpg" alt="Banner of user" class="w-full h-full">
            </div>

        <div class="info p-4">
            <img class="profile-picture absolute rounded-full h-72 w-72 top-52 border-4 border-stone-500" src="<?= $GLOBALS['base_url'] ?>/../public/images/defaultUser.png" alt="Picture of user">
            <div class="clear h-28"></div>

            <h2 class="name font-bold text-2xl">This user does not exist!</h2>
        </div>

        <div class="undefined text-center break-words my-4 text-gray-200 text-2xl p-4">
            <span class="block">
                <i class="fas fa-frown-open"></i>
                This user does not exist, why are you here?
            </span>
            <span>Go back to the <a href="home" class="text-indigo-500">home page</a> and try again!</span>
        </div>
    </div>
</div>
<?php 

    include('partials/message.php');
    require('partials/footer.php');
?>