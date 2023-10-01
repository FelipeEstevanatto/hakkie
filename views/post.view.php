<?php

    require('partials/header.php');
    include('partials/tool-bar.php');

?>

    <div id="container">
        <div id="feed">
            <?php
                include(__DIR__.'/../../../app/php/showPosts.php');

                showPosts($conn, $id, 1, $_GET['id']);

            ?>
        </div>
    </div>

    <?php 

        include('partials/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript"src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>

</body>
</html>