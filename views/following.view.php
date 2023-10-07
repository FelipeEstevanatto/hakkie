<?php
    require('partials/header.php');
    require('partials/tool-bar.php');

    $picture = is_null($picture) ? '../images/defaultUser.png' : $picture;
    $picture_url = $isGoogle ? $picture : '../images/'.$picture;
?>

<div id="container" class="flex justify-center bg-almost-black text-white min-h-screen p-8 relative"> 
    <div id="feed" class="w-screen lg:w-1/2 p-4">
        <div class="top">
            <img class="profile-picture" src="<?=$picture_url?>" alt="Picture of user">

            <a href="user=<?=$GET_user?>"><?=$user_name?></a>
         </div>

         <div class="tab-list">
            <a href="following=<?=$GET_user?>" class="tab">
                (<?=$following?>) Following
                <div class="underline"></div>
            </a>
            <a href="followers=<?=$GET_user?>" class="tab">
                (<?=$followers?>) Followers
            </a>
        </div>

         <div id="feed">
             <!--Follow layout-->
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
                                <a href="user?user='.$users['user_followed'].'">'.$users['username'].'</a>
                            </div>
                            
                            <div class="btn follow">
                                <i class="fas fa-user-plus"></i>
                                <a href="user?user='.$users['fk_user'].'"><span>Follow</span></a>
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
</div>
<?php 

    include('partials/message.php');
    require('partials/footer.php');
?>
