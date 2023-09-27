<?php

require('partials/header.php');
include('partials/tool-bar.php');

?>

    <div id="container">

        <div class="top">
            <img class="profile-picture" src="<?=$picture?>" alt="Picture of user">
            <a href="user?user=<?=encodeId($GET_user)?>"><?=$user_name?></a>
         </div>

        <div class="tab-list">
            <a href="following?user=<?=encodeId($GET_user)?>" class="tab">
                (<?=$following?>) Following
            </a>
            <a href="followers?user=<?=encodeId($GET_user)?>" class="tab">
                (<?=$followers?>) Followers
                <div class="underline"></div>
            </a>
        </div>

         <div id="feed">
            <?php
                foreach ($data as $users) {
                    $each_user ='
                    <div class="user-box">
                        <div class="box-top">
                            <div class="info">
                                <img src="';
                                if ($users['auth_type'] == 'GOOGLE') {
                                    $each_user .= $users['picture'];
                                } elseif (!is_null($picture)) {
                                    $each_user .= '../images/'.$users['picture'];
                                } else {
                                    $each_user .= '../images/defaultUser.png'; // Fallback
                                }
                        $each_user .='" alt="Picture of user">
                                <a href="user?user='.encodeId($users['fk_user']).'">'.$users['username'].'</a>
                            </div>
                            
                            <div class="btn follow">
                                <i class="fas fa-user-plus"></i>
                                <a href="user?user='.encodeId($$users['fk_user']).'"><span>Follow</span></a>
                            </div>
                        </div>

                        <div class="box-date">
                            <span>Following since: '.str_replace('-','/',substr($users['follow_date'],0,10)).'</span>
                        </div>

                        <div class="box-about">';
                        if (!is_null($users['user_info']))
                            $each_user .= $users['user_info'];
                        $each_user .='
                        </div>

                        <div class="btn-responsive">
                            <i class="fas fa-user-plus"></i>
                            <span>Follow</span>
                        </div>
                    </div>
                    ';
                    echo$each_user;
                }
            ?>
            
         </div>
    </div>

    <?php 

        include(__DIR__.'/../includes/message.php')

    ?>

</body>
</html>