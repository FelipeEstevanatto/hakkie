<?php
    

    if(!isset($_SESSION['isAuth'])){
        header("Location: home ");
	    exit();
    }

    include(__DIR__ . "/../../bootstrap.php");
    include(__DIR__ . "/../../app/php/functions.php");

    $query = "SELECT username, email, user_info, darkmode FROM users WHERE id = :id";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
    $stmt -> execute();

    if ($stmt -> rowCount() < 1) {
        header("Location: login"); //This user does not exist in DB!
        exit();
    }

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    $name = $return['username'];
    $email = $return['email'];
    $info = $return['user_info'];
    $darkMode = $return['darkmode'];

    $query = "SELECT * FROM blocks WHERE fk_user = :id";
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
    $stmt -> execute();
    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) < 1 ) {
        $hasBlocks = false;
    } else {
        $hasBlocks = true;

        $query = 'SELECT users.id, users.username, users.picture, users.auth_type, blocks.block_date, blocks.id_block
                  FROM users INNER JOIN blocks
                  ON users.id = blocks.user_blocked WHERE blocks.fk_user = :id;';
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
        $stmt -> execute();
        
        $blocks = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/settings/settings.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/home/grid/grid.css">
    <link rel="stylesheet" href="<?= $GLOBALS['base_url'] ?>public/css/style.css">

    <!-- Font Awesome-->
    <script src="https://kit.fontawesome.com/a39639353a.js" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body class="<?=$_COOKIE['darkMode'];?>">
    
    <?php

        include(__DIR__ . '/../includes/no-script.php');
        include(__DIR__ . '/../includes/tool-bar.php')
        
    ?>

    <div id="container">
        <h1>Settings</h1>
        
        <div class="settings">
            <!-- Theme -->
            <div class="theme-box">
                <label for="theme-check" id="switch-theme-btn">
                    <input type="checkbox" id="theme-check" name="theme-check" <?php if($_COOKIE['darkMode'] == 'dark') echo 'checked' ?> >
                    <span class="slider"></span>
                </label>

                <span id="theme-state">DarkMode: <?php if($_COOKIE['darkMode'] == 'dark') echo '<span>ON</span>'; else echo '<span>OFF</span>'; ?></span>
            </div>

            <h3>Profile</h3>

            <!-- Block -->
            <div class="btn">
                <i class="fas fa-user-lock"></i>
                <span>Manage Blocks</span>
            </div>

            <div id="block-manage" class="form-manage close">
                <?php
                    if ($hasBlocks) {
                        foreach ($blocks as $blocked_user) {
                            $div = '
                            <div class="block" id="'.encodeId($blocked_user['id']).'">
                                <div class="left">  
                                    <img src="';
                                    if ($blocked_user['auth_type'] == 'GOOGLE') {
                                        $div .= $blocked_user['picture'];
                                    } else if ( !is_null($blocked_user['picture']) ) { 
                                        $div .= $GLOBALS['base_url'] . '/../profiles/pictures/'.$blocked_user['picture'];
                                    } else {
                                        $div .= $GLOBALS['base_url'] . '/../public/images/defaultUser.png';
                                    }
                                    $div .= '" alt="user-blocked-picture" width=50px style="clip-path:circle();">
                                    <a href="#">'.$blocked_user['username'].'</a>';
                                 $div .='
                                </div>

                                <div class="right">
                                    <i class="fas fa-times" id="unblock-user-btn'.$blocked_user['id_block'].'"></i>                    
                                </div>
                
                                    <div class="time">Blocked since: '.$blocked_user['block_date'].'</div>

                            </div>';
                            echo $div;
                        }
                    } else {
                        echo "<span> <i class='fas fa-thumbs-up'></i> You have no blocks, nice!</span>";
                    }
                    
                ?>
            </div>

            <!-- Name -->
            <div class="btn">
                <i class="fas fa-signature"></i>
                <span>Exchange Name</span>
            </div>

            <div class="form-manage close">
                <form action="changeUserData" method="POST">
                    <label for="current-name">Current Name</label> 
                    <input type="text" placeholder="<?php echo$name ?>" disabled>

                    <label for="name">New Name</label> 
                    <input type="text" name="name" id="name">

                    <input type="submit" name='change-user-name' value="Submit">
                </form>
            </div>

            <!-- Info -->
            <div class="btn">
                <i class="fas fa-info-circle"></i>
                <span>Edit Info</span>
            </div>
            <div class="form-manage close">
                <form action="changeUserData" method="POST">
                    <label for="update-info">Current info about you:</label>

                    <textarea id="textarea" name="update-info" type="text" maxlength="256" rows="3"><?php
                        if (!is_null($info)) {
                            echo $info;
                        } 
                    ?></textarea>
                    <label id="count" for="update-info"></label>

                    <input type="submit" name='change-user-info' value="Submit">
                </form>
            </div>
            <?php if( isset($_SESSION['authType']) && $_SESSION['authType'] != 'GOOGLE') {?>
            <h3>Security</h3>

            <!-- Email -->
            <div class="btn">
                <i class="fas fa-at"></i>
                <span>Change Email</span>
            </div>

            <div class="form-manage close">
                <form action="changeUserData" method="POST">
                    <label for="current-email">Current Email</label> 
                    <input type="email" placeholder="<?php echo$email ?>" disabled>

                    <label for="email">New Email</label> 
                    <input type="email" name="email" id="email">

                    <input type="submit" name='change-user-email' value="Submit">
                </form>
            </div>

            <!-- Password -->
            <div class="btn">
                <i class="fas fa-key"></i>
                <span>Exchange Password</span>
            </div>

            <div class="form-manage close">
                <form action="changeUserData" method="POST">
                    <label for="current-password">Current Password</label> 
                    <input type="password" name="current-password" id="current-password" placeholder="You current password">

                    <label for="password">New Password</label> 
                    <div class="show-password">
                        <input type="password" name="password" id="password" placeholder="New password">
                        <i class="fas fa-eye-slash" id="show-password-btn"></i>
                    </div>

                    <input type="submit" name='change-user-password' value="Submit">
                </form>
            </div>
            <?php   } ?>
            <a href="logout">
                <div class="btn" id="logout-btn">
                    <i class="fas fa-door-open"></i>
                    <span>Logout</span>
                </div>
            </a> 
        </div>
    </div>

    <?php 
        include(__DIR__ . '/../includes/message.php')
    ?>

    <script src="<?= $GLOBALS['base_url'] ?>/js/switchTheme.js"></script>
    <?php if( isset($_SESSION['authType']) && $_SESSION['authType'] != 'GOOGLE') {?>
        <script src="<?= $GLOBALS['base_url'] ?>/js/showPassword.js"></script>
    <?php } ?>
    <script src="<?= $GLOBALS['base_url'] ?>/js/openSettings.js"></script>
    <script src="<?= $GLOBALS['base_url'] ?>/js/letterCount.js"></script>
</body>
</html>