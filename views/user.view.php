<?php
    
    require('partials/header.php');
    include('partials/no-script.php');
    include('partials/tool-bar.php');

?>
    <div class="flex justify-center bg-almost-black text-white min-h-screen border-x-2 border-slate-500 p-8 relative">
        <div class="w-1/2">
            <div class="top">
                <div class="banner">
                    <img src="<?= $GLOBALS['base_url'] . "/../public/images/" ?><?= is_null($banner) ? "defaultBanner.jpg" : $banner ?>" alt="Banner of user">
                </div>
    
                <div class="info">
                    <img class="profile-picture" src="<?= is_null($picture) ? $GLOBALS['base_url']."/../public/images/defaultUser.png" : "$picture" ?>" alt="Picture of user">
                    <div class="time">
                        <i class="fas fa-calendar-alt"></i>
                        Joined <?=$user_since?>
                    </div>
    
                    <div class="clear"></div>
    
                    <h2 class="name"><?=$user_name?></h2>
    
                    <p class="description">
                        <?php
                            echo !is_null($user_info) ? $user_info : 'Nothing to say.';
                        ?>
                    </p>
    
                    <div class="bottom-bar">
                        <div class="left">
                            <a href="following?user=<?=$_GET['user']?>">
                                <span id="following"><?=$following?></span>
                                Following
                            </a>
    
                            <a href="followers?user=<?=$_GET['user']?>">
                                <span id="followers"><?=$followers?></span>
                                Followers
                            </a>
                        </div>
    
                        <div class="right">
                            <?php 
                            
                                if (!$own_profile) {
                                    echo'<div class="btn '.$follow_status.'" id="interact-btn">';
                                    if ($follow_status == 'Follow') {
                                        echo '<i class="fas fa-user-plus"></i>';
                                    } else
                                        echo'<i class="fas fa-user-times"></i>';
                                        echo'<span> '.$follow_status.'</span>
                                        </div>';
                                } 
                      
                            ?>
    
                            <div class="btn" id="direct_message">
                                <i class="fas fa-comment-dots"></i>
                            </div>
    
                            <div id="ellipsis-modal" class="close">
                            <?php 
    
                                if (!$own_profile) {
                                echo '<div class="btn" id="silence_user">Silence User</div>
                                      <div class="btn" id="block_user">Block User</div>';
                                } else {
                                    echo '<a href="settings"><div class="btn" id="edit_user">Edit User</div></a>';
                                }
    
                            ?>
                                <div class="btn" id="link_user">Copy Profile Link</div>
                            </div>
    
                            <div id="ellipsis" class="btn">
                                <i class="fas fa-ellipsis-v"></i>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
    
            <div class="tab-list">
                <div class="tab">
                    Posts
                    <div class="underline"></div>
                </div>
                <div class="tab">
                    Media
                    <div class=""></div>
                </div>
                <div class="tab">
                    Likes
                    <div class=""></div>
                </div>
            </div>
    
            <?php 
                if ($own_profile) {
            ?>
    
            <div class="post-input">
                <h2>Post</h2>
                <form action="postLogic" method="POST" enctype='multipart/form-data'>
                    <textarea name="post-text" id="textarea" maxlength="256" cols="30" rows="10" placeholder="What is going on?"></textarea>
                    <label id="count" for="post-text"></label>
    
                    <div id="images-preview"></div>
                        
                    <input type='file' id="uploadfile" name='uploadfile[]' accept='.png,.PNG,.JPG,.jpg,.JPEG,.webpm,.mp4,.mov,.gif' multiple style='display:none;' @change="trySubmitFile"/>
                    <label id="uploadfile-label" for="uploadfile">
                        <span><i class="fas fa-upload"></i></span>     
                    </label>
                    <input type="submit" value="Submit">
                </form>
            </div>
            <script>
            function trySubmitFile(e) {
                if (this.disabled) return;
                const files = e.target.files || e.dataTransfer.files;
                if (files.length > 4) {
                    alert('You are only allowed to upload a maximum of 2 files at a time');
                }
                if (!files.length) return;
                for (let i = 0; i < Math.min(files.length, 2); i++) {
                    this.fileCallback(files[i]);
                }
            }
          </script>
            <?php
            }
            ?>
        
            <div id="feed">        
                <?php
                    include(__DIR__ . "/../../app/php/showPosts.php");
    
                    // Post layout
                    showPosts($conn, decodeId($_GET['user']), 10);
    
                    echo'<div class="post text">
                    No more posts from this user to show!
                    </div>';
                ?>
     
            </div>
        </div>
    </div>

    <?php 

        include(__DIR__ . '/../includes/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/openMenu.js"></script>   

    
    
    <script type="text/javascript" src="/js/<?= !$own_profile ? 'followUser.js' : 'imagePreview.js' ?>"></script>   

    <?php 
        if ($own_profile) {   
    ?>
        <script src="<?= $GLOBALS['base_url'] ?>/js/letterCount.js">
            letterCount(140, 'post-text', 'post-count')
        </script>
    <?php } ?>
</body>
</html>