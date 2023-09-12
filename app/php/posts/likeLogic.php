<?php



require_once(__DIR__."/../../../bootstrap.php");
require_once(__DIR__."/../functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Like
if (isset($_POST['like']) && !is_numeric($_POST['like'])) {

    $query = 'INSERT INTO likes VALUES(DEFAULT, :id_post , DEFAULT, :id_user) ON CONFLICT DO NOTHING;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_post', decodeId($_POST['like']), PDO::PARAM_INT);
    $stmt -> bindValue(':id_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    $stmt -> execute();

    if ($stmt && $stmt -> rowCount() > 0) {
        echo"1";
    }

//Unlike
} else if (isset($_POST['unlike']) && !is_numeric($_POST['unlike'])) {

    $query = 'DELETE FROM likes WHERE fk_like_owner = :id_user AND fk_post = :id_post;';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    $stmt -> bindValue(':id_post', decodeId($_POST['unlike']), PDO::PARAM_INT);
    
    $stmt -> execute();

    if ($stmt && $stmt -> rowCount() > 0) {
        echo"0";
    }

}