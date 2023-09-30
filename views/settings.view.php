<?php

    require('partials/header.php');
    include('partials/no-script.php');
    include('partials/tool-bar.php');
    // dd($_SESSION);
    
?>
    <div id="container" class="flex justify-center bg-almost-black text-white min-h-screen p-8 relative"> 
        <div class="settings pb-24 w-1/2 p-8 font-popins">
            <span class="font-bold text-4xl block">Settings</span>
            <!-- Theme -->
            <label class="relative inline-flex items-center cursor-pointer my-8">
                <input type="checkbox" value="" id="theme-check" name="theme-check" <?= $_SESSION['user']['theme'] == 'dark' ? 'checked' : '' ?> class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-bold text-gray-900 dark:text-gray-300">DarkMode: <span id="theme-state"><?= $_SESSION['user']['theme'] == 'dark' ?  'ON' : 'OFF' ?></span></span>
            </label>

            <h3 class="mb-4 text-2xl font-bold">Profile</h3>
            <div class="relative">

            <!-- Block -->
            <div id="block" class="btn bg-gradient-to-r from-indigo-600 to-orange-700 p-4 rounded-t-lg rounded-b-lg text-xl bg-gradient-to-r from-indigo-600 to-orange-700 p-4 text-xl mb-6 cursor-pointer">
                <i class="fas fa-user-lock"></i>
                <span>Manage Blocks</span>
            </div>

            <div id="block-manage" class="hidden close px-8 py-4 drop-shadow-md border-2 border-gray-700 rounded-b-lg mb-6">
                <?php
                    if ($hasBlocks) {
                        foreach ($blocks as $blocked_user) {
                            $photo_path = $GLOBALS['base_url'] . '/../public/' . $blocked_user['picture'] ?? '/images/defaultUser.png';
                        ?>
                            <div class="block" id="<?=$blocked_user['id']?>">
                                <div class="left">  
                                    <img src="<?$photo_path?>" alt="user-blocked-picture" width=50px style="clip-path:circle();">
                                    <a href="#"><?=$blocked_user['username']?></a>
                                </div>

                                <div class="right">
                                    <i class="fas fa-times" id="unblock-user-btn'.$blocked_user['id'].'"></i>                    
                                </div>
                                <div class="time">Blocked since: <?=$blocked_user['block_date']?></div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                            <span> <i class='fas fa-thumbs-up'></i> You have no blocks, nice!</span>
                        <?php
                    }
                    
                ?>
            </div>

            <!-- Name -->
            <div id="name" class="btn bg-gradient-to-r from-indigo-600 to-orange-700 p-4 rounded-t-lg rounded-b-lg text-xl mb-6 cursor-pointer">
                <i class="fas fa-signature"></i>
                <span>Exchange Name</span>
            </div>

            <div id="name-manage" class="hidden px-8 py-4 drop-shadow-md border-2 border-gray-700 rounded-b-lg mb-6">
                <form action="changeUserData" method="POST">
                    <div class="mb-8">
                        <label for="current-name" class="font-medium">Current Name</label>
                        <div class="relative">
                            <input type="text" name="current-name" id="current-name" value="<?=$name?>" readonly class="w-full p-4 rounded-lg text-black font-normal">
                        </div>
                    </div>
                    <div class="mb-8">
                        <label for="email" class="font-medium">New Name</label>
                        <div class="relative">
                            <input type="text" name="name" id="name" required class="w-full p-4 rounded-lg text-black font-normal" placeholder="New Name">
                        </div>
                    </div>
                    <input type="submit" name='change-user-name' value="Submit" class="py-4 px-12 bg-green-800 rounded-lg font-bold">
                </form>
            </div>

            <!-- Info -->
            <div id="info" class="btn bg-gradient-to-r from-indigo-600 to-orange-700 p-4 rounded-t-lg rounded-b-lg text-xl mb-6 cursor-pointer">
                <i class="fas fa-info-circle"></i>
                <span>Edit Info</span>
            </div>
            <div id="info-manage" class="hidden close px-8 py-4 drop-shadow-md border-2 border-gray-700 rounded-b-lg mb-6">
                <form action="changeUserData" method="POST">
                    <label for="update-info">Current info about you:</label>

                    <textarea id="textarea" name="update-info" type="text" maxlength="256" rows="3" class="w-full bg-gray-700 rounded-lg p-2"><?=!is_null($info) ? $info : '' ?></textarea>
                    <label id="count" for="update-info" class="absolute right-10 bottom-20 text-right w-auto rounded-full font-normal"></label>

                    <input type="submit" name='change-user-info' value="Submit" class="py-4 px-12 bg-green-800 rounded-lg font-bold">
                </form>
            </div>
            <?php if( isset($_SESSION['user']['authType']) && $_SESSION['user']['authType'] != 'GOOGLE') {?>
            <h3 class="mb-4 text-2xl font-bold">Security</h3>

            <!-- Email -->
            <div id="email" class="btn bg-gradient-to-r from-indigo-600 to-orange-700 p-4 rounded-t-lg rounded-b-lg text-xl mb-6 cursor-pointer">
                <i class="fas fa-at"></i>
                <span>Change Email</span>
            </div>

            <div id="email-manage" class="hidden close px-8 py-4 drop-shadow-md border-2 border-gray-700 rounded-b-lg mb-6">
                <form action="changeUserData" method="POST">
                    <div class="mb-8">
                        <label for="current-email" class="font-medium">Current Email</label>
                        <div class="relative">
                            <input type="email" name="current-email" id="current-email" placeholder="<?=$email?>" required class="w-full p-4 rounded-lg text-black font-normal">
                        </div>
                    </div>
                    <div class="mb-8">
                        <label for="email" class="font-medium">New Email</label>
                        <div class="relative">
                            <input type="email" name="change-user-email" id="change-user-email" required class="w-full p-4 rounded-lg text-black font-normal" placeholder="New Email">
                        </div>
                    </div>
                    <input type="submit" name='change-user-email' value="Submit" class="py-4 px-12 bg-green-800 rounded-lg font-bold">
                </form>
            </div>

            <!-- Password -->
            <div id="password" class="btn bg-gradient-to-r from-indigo-600 to-orange-700 p-4 rounded-t-lg rounded-b-lg text-xl mb-6 cursor-pointer">
                <i class="fas fa-key"></i>
                <span>Exchange Password</span>
            </div>

            <div id="password-manage" class="hidden close px-8 py-4 drop-shadow-md border-2 border-gray-700 rounded-b-lg mb-6">
                <form action="changeUserData" method="POST">
                    <div class="mb-8">
                        <label for="current-password" class="font-medium">Current Password</label>
                        <div class="relative">
                            <input type="password" name="current-password" id="current-password" placeholder="You current password" required class="w-full p-4 rounded-lg text-black font-normal">
                            <i class="text-gray-300 fas fa-eye-slash absolute top-0 right-0 p-4 cursor-pointer text-xl" id="show-password-btn"></i>
                        </div>
                    </div>
                    <div class="mb-8">
                        <label for="password" class="font-medium">New Password</label>
                        <div class="relative">
                            <input type="password" name="password-repeat" id="password-repeat" required class="w-full p-4 rounded-lg text-black font-normal" placeholder="New password">
                        </div>
                    </div>
                    <input type="submit" name='change-user-password' value="Submit" class="py-4 px-12 bg-green-800 rounded-lg font-bold">
                </form>
            </div>
            <?php   } ?>
            <form method="POST" action="session">
                <input type="hidden" name="_method" value="DELETE"/>
                <div class="p-4 bg-red-500 rounded-lg w-1/4" id="logout-btn">
                    <i class="fas fa-door-open"></i>
                    <button>Logout</button>
                </div>
            </form> 
        </div>
    </div>

    <?php 
        include('partials/message.php')
    ?>

    <script src="<?= $GLOBALS['base_url'] ?>/js/switchTheme.js"></script>
    <?php if( isset($_SESSION['user']['authType']) && $_SESSION['user']['authType'] != 'GOOGLE') {?>
        <script src="<?= $GLOBALS['base_url'] ?>/js/showPassword.js"></script>
    <?php } ?>
    <script src="<?= $GLOBALS['base_url'] ?>/js/openSettings.js"></script>
    <script src="<?= $GLOBALS['base_url'] ?>/js/letterCount.js"></script>
</body>
</html>