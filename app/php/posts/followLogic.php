<?php



require_once(__DIR__."/../../../bootstrap.php");
require(__DIR__."/../functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Follow
if (isset($_POST['follow']) || !is_numeric($_POST['unfollow'])) {

    // Check if user is already following
    $query = 'SELECT * FROM follows WHERE user_followed = :user_followed AND fk_user = :id;';
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', decodeId($_POST['follow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id', decodeId($_SESSION['user']['id']), PDO::PARAM_INT);
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ( count($return) > 0 ) {
        $query = 'DELETE FROM follows WHERE user_followed = :user_followed AND fk_user = :id;';
    } else {
        $query = 'INSERT IGNORE INTO follows VALUES(DEFAULT, :user_followed , DEFAULT, :id);';
    }
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', decodeId($_POST['follow']), PDO::PARAM_INT);
    $stmt -> bindValue(':id', decodeId($_SESSION['user']['id']), PDO::PARAM_INT);
    
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    // explain the return of fetch
    var_dump($return);
    if ($stmt == 1) {
        echo"Success";
    }
}

$conn = null;
