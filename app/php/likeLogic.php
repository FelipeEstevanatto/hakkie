<?php

session_start();

require_once("../database/connect.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

//Like
if (isset($_POST['like']) && is_numeric($_POST['like'])) {

    $query ='
        DO
        $do$
            DECLARE 
                v_RowCountInt Int;
            BEGIN
            INSERT INTO likes 
                VALUES(DEFAULT, :id_post , :id_user) ON CONFLICT DO NOTHING;
            GET DIAGNOSTICS 
                v_RowCountInt = ROW_COUNT;
            IF ( v_RowCountInt > 0 ) THEN
                UPDATE posts SET post_likes = post_likes+1 WHERE id_post = :id_post;
            END IF;
        END
        $do$;';
    //Force PDO to either always emulate prepared statements
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_post', $_POST['like'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_post', $_POST['like'], PDO::PARAM_INT);
    
    $stmt -> execute();
 
    if ($stmt) {
        echo"1";
    }

} else if (isset($_POST['unlike']) && is_numeric($_POST['unlike'])) {

    $query = 
        'DELETE FROM likes WHERE fk_like_owner = :id_user AND fk_post = :id_post;
        UPDATE posts SET post_likes = post_likes-1 WHERE id_post = :id_post;';
    //Force PDO to either always emulate prepared statements
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', $_SESSION['idUser'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_post', $_POST['unlike'], PDO::PARAM_INT);
    $stmt -> bindValue(':id_post', $_POST['unlike'], PDO::PARAM_INT);
    
    $stmt -> execute();

    $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($stmt && count($return) == 1) {
        echo"0";
    }

}