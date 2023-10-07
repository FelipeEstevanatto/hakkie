<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;

class UserController {
    public function index() {
        $db = App::resolve(Database::class);

        $id = $_GET['user'] ?? $_SESSION['user']['id'];

        if (!isset($id) || !is_numeric($id)) {
            // Invalid user id
            view("user-nonexistent.view.php", [
                'heading' => 'User',
            ]);
            exit();    
        }

        $own_profile = true;
        include(__DIR__ . "../post/showPosts.php");
        // Get user info
        if ($id != $_SESSION['user']['id']){

            $own_profile = false;
            
            $blocks = $db->query('SELECT user_blocked, fk_user FROM blocks WHERE fk_user = :id OR user_blocked = :id',[
                'id' => $_SESSION['user']['id'],
                'id' => $_SESSION['user']['id'],
            ])->find();

            if ($blocks != null) {

                $details = $blocks;

                if ($details['fk_user'] == $_SESSION['user']['id']) {
                    $details = 'own_block';
                }

                view("user-blocked.view.php", [
                    'heading' => 'User',
                    'details' => $details,
                ]);
                exit();
            }

        }

        $user_info = $db->query('SELECT username, user_info, picture, banner, created_at, darkmode, auth_type FROM users WHERE users.id = :id;',[
            'id' => $id,
        ])->find();

        if ($user_info == null) {
            //This user does not exist in DB!
            view("user-nonexistent.view.php", [
                'heading' => 'User',
            ]);
            exit();
        }

        $user_since = joinedSince($user_info['created_at']);

        $isGoogle = ($user_info['auth_type'] == "GOOGLE") ? true : false;

        $user_name = $user_info['username'];
        $picture = $user_info['picture'];
        $banner = $user_info['banner'];
        $user_info = $user_info['user_info'];

        // Get followers, following number and if SESSION is following 
        $follow_info = $db->query('SELECT 
            COUNT(CASE WHEN user_followed = :id THEN 1 END) AS followers,
            COUNT(CASE WHEN fk_user = :id THEN 1 END) AS followings,
            EXISTS (SELECT user_followed FROM follows WHERE fk_user = :fk_user AND 
            fk_user IS NOT NULL AND fk_user != :id ) AS isfollowing
            FROM follows;',
        [
            'id' => $id,
            'id' => $id,
            'fk_user' => $_SESSION['user']['id'],
        ])->find();

        $followers = $follow_info['followers'];
        $following = $follow_info['followings'];
        $follow_status = $follow_info['isfollowing'] ? 'Unfollow' : 'follow';

        view("user.view.php", [
            'heading' => 'User',
            'own_profile' => $own_profile,
            'user_name' => $user_name,
            'picture' => $picture,
            'banner' => $banner,
            'user_info' => $user_info,
            'user_since' => $user_since,
            'followers' => $followers,
            'following' => $following,
            'follow_status' => $follow_status,
            'isGoogle' => $isGoogle,

        ]);
    }

    public function edit() {
        $db = App::resolve(Database::class);

        $return = $db->query('SELECT username, email, password, user_info FROM users WHERE id = :id',[
            'id' => $_SESSION['user']['id'],
        ])->find();
        
        if ( isset($_POST['change-user-name']) ) {
        
            $newName = $_POST['name'];
        
            if (empty($newName) && strlen($newName) > 64 && $newName !== $return['username']) {
                header("Location: settings?error=invalidname");
                exit();
            }
        
            echo"change user name";
            $result = $db->query('UPDATE users SET username = :newname WHERE id = :id',[
                'newname' => $newName,
                'id' => $_SESSION['user']['id'],
            ]);
        
            if ($result == null) {
                header("Location: settings?error=invalidname");
                exit();
            }
            
        } elseif ( isset($_POST['change-user-email']) ) {
        
            $newEmail = $_POST['email'];
        
            if ($newEmail === false && $newEmail !== $return['email']) {
                header("Location: settings?error=invalidemail");
                exit();
            }
        
            echo"change user email";
            $result = $db->query('UPDATE users SET email = :newEmail WHERE id = :id',[
                'newEmail' => $newEmail,
                'id' => $_SESSION['user']['id'],
            ]);
            
            if($result == null) {
                header("Location: settings?error=invalidemail");
                exit();
            }
        
        } elseif ( isset($_POST['change-user-password']) ) {
        
            $newPass = $_POST['password'];
        
            if (empty($newPass) && strlen($newPass) > 255) {
                header("Location: settings?error=invalidpassword");
                exit();
            }
        
            $hashednewPass = password_hash($newPass, PASSWORD_BCRYPT);
        
            echo"change user pass";
            $result = $db->query('UPDATE users SET password = :newPass WHERE id = :id',[
                'newPass' => $hashednewPass,
                'id' => $_SESSION['user']['id'],
            ]);
        
            if ($result == null) {
                header("Location: settings?error=invalidpassword");
                exit();
            }
        } elseif ( isset($_POST['change-user-info']) ) {
        
            $newInfo = $_POST['update-info'];
        
            if (empty($newInfo) && strlen($newInfo) > 256 && $newInfo !== $return['user_info']) {
                header("Location: settings?error=invalidpassword");
                exit();
            }
        
            echo"change user info";
            $result = $db->query('UPDATE users SET user_info = :newInfo WHERE id = :id',[
                'newInfo' => $newInfo,
                'id' => $_SESSION['user']['id'],
            ]);
        
            if ($result == null) {
                header("Location: settings?error=invalidpassword");
                exit();
            }
        }
        
        header('Location: settings?nice');
        exit();
    }
}