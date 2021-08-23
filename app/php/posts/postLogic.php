<?php

session_start();

require_once("../../database/connect.php");
require_once("../functions.php");

if(!isset($_SESSION['isAuth'])){
    exit();
}

if ( (!empty($_POST['post-text']) && strlen($_POST['post-text']) <= 256)|| !empty($_FILES["uploadfile"]["tmp_name"])) {
    
    $message = cleanString($_POST['post-text']);
    
    if (isset($_FILES) && !empty($_FILES["uploadfile"]["tmp_name"])) {
        if ( $_FILES['uploadfile']['size'] >= 33554432 ) { //32Mb max size
            header("Location: ../../public/views/user.php?user=".$_SESSION['idUser']."&error=bigfile");
            exit();
        }
        
        $permitedFormats = array("jpg","png","jpeg","webpm","mp4","mov","gif");
        $filetype = $_FILES['uploadfile']['type'];
        $temparray = explode("/",$filetype);
        $extension = end($temparray);

        if ( !in_array( $extension , $permitedFormats ) ) {
            header("location: ../../public/views/user.php?user=".$_SESSION['idUser']."&error=fileformat");
            exit;
        }
        
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "../../../public/profiles/";

        $rename = $_SESSION['idUser'].'Upload'.date('Ymd').(100*rand(0,100000)).".".$extension;

        $post_media = $rename;
        
        if (move_uploaded_file($tempname, $folder.$rename)) {
        
            $uploadfine = true;
    
        } else {
            //Failed to upload image
            header("Location: ../../../public/views/user.php?user=".$_SESSION['idUser']."&error=failedupload");
            exit();
        }
    }

    $query = "INSERT INTO posts VALUES(DEFAULT, :post_text, :post_media, DEFAULT, :id_user)";
    
    $stmt = $conn -> prepare($query);  

    if (!isset($message) || empty($message)) {
        $stmt -> bindValue(':post_text', 'NULL');
    } else {
        $stmt -> bindValue(':post_text', $message);
    }
    if (!isset($post_media) || empty($post_media)) {
        $stmt -> bindValue(':post_media', 'NULL');
    } else {
        $stmt -> bindValue(':post_media', $post_media);
    }
    
    $stmt -> bindValue(':id_user', decodeId($_SESSION['idUser']));

    $stmt -> execute();

    if (isset($uploadfine) && $stmt && $uploadfine) {
        header("Location: ../../../public/views/user.php?user=".$_SESSION['idUser']);
        exit();

    } else {
        header("Location: ../../../public/views/user.php?user=".$_SESSION['idUser']."&error=dberror");
        exit();
    }
} else {
    header("Location: ../../../public/views/user.php?user=".$_SESSION['idUser']);
    exit();
}
