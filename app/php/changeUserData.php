<?php
    session_start();
    if(!isset($_SESSION['isAuth'])){
        header("Location: home.php ");
        exit();
    }

    print_r($_POST);
    if( isset($_POST['change-user-email']) ) {
        echo"change user email";
    }
