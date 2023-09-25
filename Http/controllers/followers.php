<?php

$query = "SELECT username, user_info, picture, created_at, auth_type, darkmode FROM users WHERE id = :id";

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':id', $GET_user);

$stmt -> execute();

$return = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() < 1) {
    include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
    exit();
}

$isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;

$user_name = $return['username'];
$picture = $return['picture'];
$user_info = $return['user_info'];

$query = 'SELECT user_followed, follow_date, fk_user, username, picture, user_info, auth_type FROM follows 
          INNER JOIN users ON id = fk_user WHERE user_followed = :id ORDER BY follow_date';
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':id', $GET_user);
$stmt -> execute();
$data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

$followers = count($data);

$query = "SELECT user_followed, follow_date, fk_user FROM follows WHERE fk_user = :id ORDER BY follow_date";
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':id', $GET_user);
$stmt -> execute();
$return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

$following = count($return);

if (!$isGoogle) {
    if (!is_null($picture)) {
        $picture = '../public/images/defaultUser.png';
    } else { //fallback
        $picture = '../public/images/defaultUser.png';
    }
}

view("followers.view.php", [
    'heading' => 'followers',
]);