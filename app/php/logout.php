<?php

    require_once("../database/connect.php");

    if (isset($google_client)) {
        $google_client = null;
    }

    session_destroy();
    $conn = null;

    header('Location: ../../index.php');
    exit();
