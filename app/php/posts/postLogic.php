<?php

require_once(__DIR__ . "/../../../bootstrap.php");
require_once(__DIR__ . "/../functions.php");

if(!isset($_SESSION['isAuth']) || count($_FILES["uploadfile"]['name']) > 4){
    header("location: user?user=".$_SESSION['idUser']."&error=toomuchfiles");
    exit();
}

date_default_timezone_set('America/Sao_Paulo');

if ( (!empty($_POST['post-text']) && strlen($_POST['post-text']) <= 256)|| !empty($_FILES["uploadfile"]["tmp_name"][0])) {
    
    $message = cleanString($_POST['post-text']) ?? '';
    
    $query = 'INSERT INTO posts VALUES(DEFAULT, :content, DEFAULT, :id);';
    $stmt = $conn -> prepare($query);  

    if (empty($message)) {
        $stmt -> bindValue(':content', 'NULL');
    } else {
        $stmt -> bindValue(':content', $message);
    }
    
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
    $stmt -> execute();

    // Get post id
    $query = 'SELECT id_post FROM posts WHERE fk_owner = :id ORDER BY id_post DESC LIMIT 1';
    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', decodeId($_SESSION['idUser']));
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    $postId = $return["id_post"];

    if (isset($_FILES) && !empty($_FILES["uploadfile"]["tmp_name"])) {

        // File extension verification ====================================
        $permitedFormats = array("jpg","png","jpeg","webm","mp4","mov","gif");
        $renamed = Array();
        $extensions = Array();

        foreach ($_FILES['uploadfile']['type'] as $filestype) {
            
            $temparray = explode("/",$filestype);
            $extension = strtolower(end($temparray));

            if ( !in_array( $extension , $permitedFormats ) ) {
                header("location: user?user=".$_SESSION['idUser']."&error=fileformat");
                exit;
            }

            array_push($renamed, $_SESSION['idUser'].'Upload'.date('Ymd').(100*rand(0,100000)).".".$extension);
            array_push($extensions, $extension);
        }

        // File sizes verification ====================================
        foreach ($_FILES['uploadfile']['size'] as $filessize) {
            if ( $filessize >= 33554432 ) { //32Mb max size
                header("Location: user?user=".$_SESSION['idUser']."&error=bigfile");
                exit();
            }
        }

        $folder = str_replace("\\", '/',substr(__DIR__,0,-13))."public/posts/";

        foreach ($_FILES['uploadfile']['tmp_name'] as $key => $filestempname) {

            if (!move_uploaded_file($filestempname, $folder.$renamed[$key])) {
                header("Location: user?user=".$_SESSION['idUser']."&error=failedupload");
                exit();
            }
        }
        
        //Insert in table
        foreach ($renamed as $key => $imagename) {
            $query = 'INSERT INTO files (file_name, file_type, fk_post, fk_owner)
                      VALUES( :file_name, :file_type, :fk_post, :session_user)';
            $stmt = $conn -> prepare($query);
            $stmt -> bindValue(":file_name", $imagename, PDO::PARAM_STR);
            $stmt -> bindValue(":file_type", $extensions[$key], PDO::PARAM_STR);
            $stmt -> bindValue(":fk_post", $postId, PDO::PARAM_INT);
            $stmt -> bindValue(":session_user", decodeId($_SESSION['idUser']), PDO::PARAM_INT);

            $stmt -> execute();
        }
        
        echo"tudo certo";
        //exit;

    }

    

    if ( $stmt ) {
        header("Location: user?user=".$_SESSION['idUser']);
        exit();

    } else {
        header("Location: user?user=".$_SESSION['idUser']."&error=dberror");
        exit();
    }
} else {
    header("Location: user?user=".$_SESSION['idUser']);
    exit();
}
