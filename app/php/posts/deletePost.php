<?php

session_start();

require_once("../../database/connect.php");
require_once("../functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Follow
if (isset($_POST['deletePost']) && !is_numeric($_POST['deletePost'])) {

    $query = 'SELECT fk_owner, post_media FROM posts WHERE fk_owner = :session_user AND id_post = :id_post;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':session_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    $stmt -> bindValue(':id_post', decodeId($_POST['deletePost']), PDO::PARAM_INT);
    
    $stmt -> execute();

    if ($stmt -> rowCount() < 1) {
        exit;
    }

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    
    if (!is_null($return[0]['post_media'])) {
        if (file_exists('../../../public/profiles/'.$return[0]['post_media'])) {  
            if(!unlink('../../../public/profiles/'.$return[0]['post_media'])){
                echo "Something went wrong deleting the media";
            }
        }
    }

    $query = 'DELETE FROM likes WHERE fk_post = :id_post;';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_post', decodeId($_POST['deletePost']), PDO::PARAM_INT);
    $result = $stmt -> execute();

    $query = 'DELETE FROM comments WHERE fk_post = :id_post;';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_post', decodeId($_POST['deletePost']), PDO::PARAM_INT);
    $result2 = $stmt -> execute();

    $query = 'DELETE FROM posts WHERE fk_owner = :session_user AND id_post = :id_post;';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':session_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    $stmt -> bindValue(':id_post', decodeId($_POST['deletePost']), PDO::PARAM_INT);
    $result3 = $stmt -> execute();

    if ($result && $result2 && $result3) {
        echo"Deleted";
    } else {
        echo"Something went wrong";
    }

}