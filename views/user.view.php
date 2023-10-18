<?php
    
    require('partials/header.php');
    include('partials/tool-bar.php');
    include('partials/no-script.php');

?>
    <div class="flex justify-center bg-gray-200 dark:bg-almost-black text-white min-h-screen relative">
        <div class="w-screen lg:w-1/2">
            <div class="top relative">
                <div class="banner w-full h-96">
                    <img src="<?= $GLOBALS['base_url'] . "/../public/images/" ?><?= is_null($banner) ? "defaultBanner.jpg" : $banner ?>" alt="Banner of user" class="w-full h-full">
                </div>
    
                <div class="info p-4 text-gray-800 dark:text-gray-200">
                    <img class="profile-picture absolute rounded-full h-72 w-72 top-52 border-4 border-stone-500" src="<?= is_null($picture) ? $GLOBALS['base_url']."/../public/images/defaultUser.png" : "$picture" ?>" alt="Picture of user">
                    <div class="time text-right text-gray-400">
                        <i class="fas fa-calendar-alt"></i>
                        Joined <?=$user_since?>
                    </div>
    
                    <div class="clear h-20"></div>
    
                    <h2 class="name font-bold text-2xl"><?=$user_name?></h2>
    
                    <p class="description text-justify break-words my-4 ">
                        <?=!is_null($user_info) ? $user_info : 'Nothing to say.';?>
                    </p>
    
                    <div class="bottom-bar flex justify-between">
                        <div class="left text-gray-400">
                            <a href="following?user=<?=$_GET['user']?>">
                                <span id="following" class="font-bold"><?=$following?></span>
                                Following
                            </a>
    
                            <a href="followers?user=<?=$_GET['user']?>">
                                <span id="followers" class="font-bold"><?=$followers?></span>
                                Followers
                            </a>
                        </div>
    
                        <div class="right flex">
                            <?php
                                if (!$own_profile) {
                                    ?>
                                        <div class="btn flex border-2 rounded-lg mr-2 cursor-pointer <?=$follow_status?>" id="interact-btn">
                                            <div class="align-middle">
                                                <i class="fas fa-user-plus"></i>
                                                <span> <?=$follow_status?></span>
                                            </div>
                                        </div>
                                    <?php
                                } 
                            ?>

                            <div class="btn border-2 border-white rounded-md mr-2 p-2 cursor-pointer" id="direct_message">
                                <i class="fas fa-comment-dots"></i>
                            </div>
    
                            <div id="ellipsis-modal" class="hidden border-2 border-stone-700 rounded-lg p-2 absolute w-32 divide-y divide-stone-700 mt-12 mr-4 bg-gray-200 dark:bg-almost-black z-50">
                            <?php 
    
                                if (!$own_profile) {
                                echo '<div class="btn hover:bg-indigo-500 rounded p-2 cursor-pointer" id="silence_user">Silence User</div>
                                      <div class="btn hover:bg-indigo-500 rounded p-2 cursor-pointer" id="block_user">Block User</div>';
                                } else {
                                    echo '<a href="settings"><div class="btn hover:bg-indigo-500 rounded p-2 cursor-pointer" id="edit_user">Edit User</div></a>';
                                }
    
                            ?>
                                <div class="btn cursor-pointer hover:bg-indigo-500 rounded p-2" id="link_user">Copy Profile Link</div>
                            </div>
    
                            <div id="ellipsis" class="btn border-2 border-white rounded-md p-2 cursor-pointer">
                                <i class="fas fa-ellipsis-v"></i>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
    
            <div class="tab-list flex text-gray-800 dark:text-gray-200">
                <div class="tab flex-grow border-2 border-stone-700/75 p-2 grid justify-items-center cursor-pointer">
                    Posts
                    <div class="underline w-1/3 bg-purple-900 h-1 rounded-full"></div>
                </div>
                <div class="tab flex-grow border-2 border-stone-700/75 p-2 grid justify-items-center cursor-pointer">
                    Media
                    <div class=""></div>
                </div>
                <div class="tab flex-grow border-2 border-stone-700/75 p-2 grid justify-items-center cursor-pointer">
                    Likes
                    <div class=""></div>
                </div>
            </div>
    
            <?php 
                if ($own_profile) {
                    if (!is_null($errors)) {
                        echo '<div class="error p-4 m-4 border-2 border-red-500 rounded-lg">';
                        foreach ($errors as $field=>$error) {
                            echo '<p class="text-red-500 font-bold">'.$error[0].'</p>';
                        }
                        echo '</div>';
                    }
            ?>
    
            <div class="post-input p-4 m-4 border-2 border-stone-700/75 rounded-lg text-gray-700 dark:text-white">
                <h2 class="font-bold text-3xl">Post</h2>
                <form action="post" method="POST" enctype='multipart/form-data' class="relative">
                    <textarea 
                        name="post-text" 
                        id="textarea" 
                        maxlength="256" cols="30" rows="10" 
                        placeholder="What is going on?"
                        class="w-full h-48 rounded-lg p-4 my-4 bg-gray-300 dark:bg-gray-800"
                    ><?= !empty($old) ? $old['post-text'] : '' ?></textarea>
                    <label id="count" for="post-text" class="absolute right-2 top-40 text-right w-auto rounded-full font-normal bg-gray-900 p-1"></label>
    
                    <div id="images-preview" class="flex mb-4"></div>
                        
                    <input 
                        type='file' 
                        id="uploadfile"
                        name='uploadfile[]'
                        accept='.png,.PNG,.JPG,.jpg,.JPEG,.webpm,.mp4,.mov,.gif'
                        multiple
                        style='display:none;'
                        @change="trySubmitFile"
                    />
                    <label id="uploadfile-label" for="uploadfile" class="border-2 border-gray-300 rounded-full py-2 px-3 absolute left-2 bottom-28 cursor-pointer">
                        <span><i class="fas fa-upload"></i></span>     
                    </label>
                    <input type="submit" value="Submit" class="p-4 rounded-lg bg-gray-300 dark:bg-gray-700 font-bold text-lg cursor-pointer">
                </form>
            </div>
            <script>
            function trySubmitFile(e) {
                if (this.disabled) return;
                const files = e.target.files || e.dataTransfer.files;
                if (files.length > 4) {
                    alert('You are only allowed to upload a maximum of 4 files at a time');
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
        
            <div id="feed" class="p-4 text-gray-800 dark:text-gray-200">        
                <?php
                    // Post layout
                    showPosts($_GET['user'], 10);
    
                    echo'<div class="post text p-6 border-2 border-gray-500 rounded-lg text-center">
                    No more posts from this user to show!
                    </div>';
                ?>
     
            </div>
            <div class="h-24 lg:h-0"></div>
        </div>
    </div>
    
    <?php 

        include('partials/message.php')

    ?>

    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/functions.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/feedbuild.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/openMenu.js"></script>   
    <script type="text/javascript" src="<?= $GLOBALS['base_url'] ?>/js/<?= !$own_profile ? 'followUser.js' : 'imagePreview.js' ?>"></script>   

<?php 
    if ($own_profile) {   
?>
    <script src="<?= $GLOBALS['base_url'] ?>/js/letterCount.js">
        letterCount(140, 'post-text', 'post-count')
    </script>
<?php }
    include('partials/footer.php');
?>