<?php

session_start();

require_once("../../database/connect.php");
require_once("../functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Follow
if (isset($_POST['deletePost']) && !is_numeric($_POST['deletePost'])) {

    $query = 'DELETE FROM files WHERE fk_post = :id_post AND fk_owner = :session_user RETURNING file_name;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_post', decodeId($_POST['deletePost']), PDO::PARAM_INT);
    $stmt -> bindValue(':session_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    
    $stmt -> execute();

    if ($stmt -> rowCount() > 0) {
        
        $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($return as $filenames) {
            if (file_exists('../../../public/posts/'.$filenames['file_name'])) {  
                if(!unlink('../../../public/posts/'.$filenames['file_name'])){
                    echo "Something went wrong deleting the media";
                }
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