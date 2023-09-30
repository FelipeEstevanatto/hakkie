<?php

namespace Http\controllers;

if ( !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    include(__DIR__."/../includes/user-nonexistent.php"); //This user does not exist in DB!
    exit();      
}

$post = decodeId($_GET['id']);

$query = "SELECT user_blocked FROM blocks WHERE fk_user = :id";
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':id', $post);
$stmt -> execute();

if ($stmt -> rowCount() > 0) {
    include(__DIR__."/../includes/user-blocked.php"); //This user does not exist in DB! (we don't have blocked page yet)
    exit();
}

$query = "SELECT id FROM users INNER JOIN posts ON fk_owner = id WHERE id = :id";
$stmt = $conn -> prepare($query);
$stmt -> bindValue(':id', $post);
$stmt -> execute();

$return = $stmt -> fetch(PDO::FETCH_ASSOC);
$id = $return['id'];

view("post.view.php", [
    'heading' => 'Home',
]);