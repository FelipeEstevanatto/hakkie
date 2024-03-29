<?php



require_once("../../database/connect.php");
require_once("../functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Follow
if (isset($_POST['follow']) && is_numeric($_POST['follow'])) {

    $query = 
        'DO
        $do$
        BEGIN
            IF (NOT EXISTS(SELECT * FROM follows WHERE fk_user = :id AND user_followed = :user_followed)) THEN
                INSERT INTO follows VALUES(DEFAULT, :user_followed , DEFAULT, :id);
            END IF;
        END
        $do$;
        UPDATE users SET user_followers = user_followers+1 WHERE id = :user_followed;
        UPDATE users SET user_following = user_following+1 WHERE id = :id;
        ';
    //Force PDO to either always emulate prepared statements
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    $stmt -> bindValue(':user_followed', decodeId($_POST['follow']), PDO::PARAM_INT);
    $stmt -> bindValue(':user_followed', decodeId($_POST['follow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    $stmt -> bindValue(':user_followed', decodeId($_POST['follow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"1";
    }

//Unfollow
} elseif (isset($_POST['unfollow']) && is_numeric($_POST['unfollow'])) {

    $query = "DELETE FROM follows WHERE user_followed = :user_unfollowed AND fk_user = :id;
             UPDATE users SET user_followers = user_followers-1 WHERE id = :user_unfollowed;
             UPDATE users SET user_following = user_following-1 WHERE id = :id;
             ";

    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $conn -> prepare($query);
    
    $stmt -> bindValue(':user_unfollowed', decodeId($_POST['unfollow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);
    $stmt -> bindValue(':user_unfollowed', decodeId($_POST['unfollow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']), PDO::PARAM_INT);

    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"0";
    }

}

$conn = null;
