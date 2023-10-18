<?php

    require('partials/header.php');
    require('partials/tool-bar.php');

?>

<div class="flex justify-center bg-gray-200 dark:bg-almost-black text-gray-800 drak:text-white min-h-screen relative">
    <div class="w-screen lg:w-1/2 p-4" id="feed">
        <?php

            showPosts($id, 1, $_GET['id']);

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