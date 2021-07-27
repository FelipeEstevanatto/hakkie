<?php

if (isset($_GET['follow']) && is_numeric($_GET['follow'])) {
    
    $query = 'INSERT INTO follows VALUES(DEFAULT, :user_followed, DEFAULT, :id_user)';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', $_GET['follow']);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    $stmt -> execute();

} elseif (isset($_GET['unfollow']) && is_numeric($_GET['unfollow'])) {

    $query = 'DELETE * FROM follows WHERE user_followed = :user_followed AND fk_user = :id_user';

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':user_followed', $_GET['follow']);
    $stmt -> bindValue(':id_user', $_SESSION['idUser']);

    $stmt -> execute();

}