<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;

class FollowingController {
    public function index() {
        $db = App::resolve(Database::class);

        $id = $_GET['user'] ?? $_SESSION['user']['id'];
        $id = filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!is_numeric($_GET['user'])) {
            include(__DIR__."/../../views/user-nonexistent"); //This user does not exist in DB!
            exit();
        }
        if ($id == $_SESSION['user']['id']) {
            $himself = true;
        }

        $return = $db->query('SELECT username, user_info, picture, banner, created_at, auth_type, darkmode FROM users WHERE id = :id',[
            'id' => $id,
        ])->find();

        //This user does not exist in DB!
        if ($return == null) {
            include(__DIR__."/../../views/user-nonexistent.php"); 
            exit();
        }

        $isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;
        $user_name = $return['username'];
        $picture = $return['picture'];
        $banner = $return['banner'];
        $user_info = $return['user_info'];
        $user_since = joinedSince($return['created_at']);

        $return = $db->query('SELECT user_followed, follow_date, fk_user FROM follows WHERE user_followed = :id ORDER BY follow_date',[
            'id' => $id,
        ])->get();

        $followers = count($return);

        $data = $db->query('SELECT user_followed, follow_date, fk_user, username, picture, user_info, auth_type FROM follows INNER JOIN users ON users.id = follows.user_followed WHERE fk_user = :id ORDER BY follow_date',[
            'id' => $id,
        ])->get();

        $following = count($data);

        view("following.view.php", [
            'heading' => 'Following',
            'user_name' => $user_name,
            'picture' => $picture,
            'banner' => $banner,
            'user_info' => $user_info,
            'followers' => $followers,
            'following' => $following,
            'himself' => $himself,
            'isGoogle' => $isGoogle,
            'data' => $data,
            'GET_user' => $id,
            'user_since' => $user_since,
        ]);
    }
}