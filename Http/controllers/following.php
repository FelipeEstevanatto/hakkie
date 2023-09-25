<?php

if ( !isset($_GET['user']) || is_numeric($_GET['user']) || is_float(decodeId($_GET['user']))) {
    include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
    exit();
} else {

    $GET_user = decodeId(filter_var($_GET['user'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    if ($_GET['user'] == $_SESSION['idUser']) {
        $himself = true;
    }
}

$query = "SELECT username, user_info, picture, banner, created_at, auth_type, darkmode 
          FROM users WHERE id = :id";

$stmt = $conn -> prepare($query);

$stmt -> bindValue(':id', $GET_user, PDO::PARAM_INT);

$stmt -> execute();

$return = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($stmt -> rowCount() < 1) {
    include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
    exit();
}

$isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;

$user_name = $return['username'];
$picture = $return['picture'];
$banner = $return['banner'];
$user_info = $return['user_info'];

$query = "SELECT user_followed, follow_date, fk_user FROM follows WHERE user_followed = :id ORDER BY follow_date";
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':id', $GET_user);
$stmt -> execute();
$return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

$followers = count($return);

$query = "SELECT user_followed, follow_date, fk_user, username, picture, user_info, auth_type FROM follows 
          INNER JOIN users ON id = user_followed WHERE fk_user = :id ORDER BY follow_date";
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':id', $GET_user);
$stmt -> execute();
$data = $stmt -> fetchAll(PDO::FETCH_ASSOC);

$following = count($data);


view("following.view.php", [
    'heading' => 'Following',
]);