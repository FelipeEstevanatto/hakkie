<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;

class FollowersController {
    public function index() {
        $db = App::resolve(Database::class);

        $return = $db->query('SELECT username, user_info, picture, created_at, auth_type, darkmode FROM users WHERE id = :id',[
            'id' => $_GET['user'] ?? $_SESSION['user']['id'],
        ])->find();

        if ($return == null) {
            include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
            exit();
        }

        $isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;

        $user_name = $return['username'];
        $picture = $return['picture'];
        $user_info = $return['user_info'];

        $data = $db->query('SELECT user_followed, follow_date, fk_user, username, picture, user_info, auth_type FROM follows 
        INNER JOIN users ON id = fk_user WHERE user_followed = :id ORDER BY follow_date',[
            'id' => $_GET['user'] ?? $_SESSION['user']['id'],
        ])->find();

        $followers = count($data);


        $return = $db->query('SELECT user_followed, follow_date, fk_user FROM follows WHERE fk_user = :id ORDER BY follow_date',[
            'id' => $_GET['user'] ?? $_SESSION['user']['id'],
        ])->find();

        $following = count($return);

        if (!$isGoogle) {
            if (!is_null($picture)) {
                $picture = '../public/images/defaultUser.png';
            } else { //fallback
                $picture = '../public/images/defaultUser.png';
            }
        }

        return view("followers.view.php", [
            'heading' => 'followers',
        ]);
    }
}