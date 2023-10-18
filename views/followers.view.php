<?php

require('partials/header.php');
include('partials/tool-bar.php');

?>

<div id="container" class="flex justify-center bg-gray-200 dark:bg-almost-black text-white min-h-screen p-8 relative"> 
    <div id="feed" class="w-screen lg:w-1/2 p-4">
        <div class="top">
            <img class="profile-picture" src="<?=$picture?>" alt="Picture of user">
            <a href="user?user=<?=$GET_user?>"><?=$user_name?></a>
         </div>

        <div class="tab-list">
            <a href="following?user=<?=$GET_user?>" class="tab">
                (<?=$following?>) Following
            </a>
            <a href="followers?user=<?=$GET_user?>" class="tab">
                (<?=$followers?>) Followers
                <div class="underline"></div>
            </a>
        </div>

         <div id="feed">
            <?php
                foreach ($data as $users) {
                    $user_picture = is_null($users['picture']) ? '../images/defaultUser.png' : '../images/'.$users['picture'];

                    echo'
                    <div class="user-box">
                        <div class="box-top">
                            <div class="info">
                                <img src="'.$user_picture.'" alt="Picture of user">
                                <a href="user?user='.$users['fk_user'].'">'.$users['username'].'</a>
                            </div>
                            
                            <div class="btn follow">
                                <i class="fas fa-user-plus"></i>
                                <a href="user?user='.$$users['fk_user'].'"><span>Follow</span></a>
                            </div>
                        </div>

                        <div class="box-date">
                            <span>Following since: '.str_replace('-','/',substr($users['follow_date'],0,10)).'</span>
                        </div>

                        <div class="box-about">';
                        if (!is_null($users['user_info']))
                        echo $users['user_info'];
                        echo'
                        </div>

                        <div class="btn-responsive">
                            <i class="fas fa-user-plus"></i>
                            <span>Follow</span>
                        </div>
                    </div>
                    ';
                }
            ?>
            
         </div>
    </div>
</div>
<?php 

    include('partials/message.php');
    include('partials/no-script.php');

?>