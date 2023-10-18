<?php 

    require('partials/header.php');  
    include('partials/tool-bar.php');
?>

    <div class="flex justify-center bg-gray-200 dark:bg-almost-black text-black dark:text-white justify-center min-h-screen">

        <div id="feed" class="w-screen lg:w-1/2 p-4">
            <?php
                foreach ($users as $user) {
                    showPosts($user['id'] , 50);
                }

                echo'<div class="post text p-6 border-2 border-gray-500 rounded-lg text-center">
                    No more posts to show!
                    </div>';
            ?>
        </div>
    </div>

    <?php 
        
        include('partials/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>

</body>
</html>