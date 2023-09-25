<?php 

    require('partials/header.php');  
    include('partials/tool-bar.php');
?>

    <div class="flex items-center justify-center bg-almost-black text-white justify-center h-screen">

        <div id="feed">
            <!-- <?php
                include(__DIR__ . '/../../app/php/showPosts.php');

                foreach ($return as $user) {

                    showPosts($conn, $user['id'] , 10);

                }

                echo'<div class="post text">
                    No more posts from this site to show!
                    </div>';

            ?> -->
        </div>
    </div>

    <?php 
        
        include(__DIR__ . '../includes/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>

</body>
</html>