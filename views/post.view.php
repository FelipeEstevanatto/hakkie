<?php

    require('partials/header.php');
    include('partials/tool-bar.php');

?>

<div class="flex justify-center bg-almost-black text-white min-h-screen relative">
    <div class="w-1/2 p-4">
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