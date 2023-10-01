<?php

namespace Http\controllers;

use Core\App;
use Core\Database;

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
$follow_status = $follow_info['isfollowing'] ? 'unfollow' : 'follow';

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