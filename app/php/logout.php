<?php

    require_once("../database/connect.php");
    include('config.php');

    if (isset($google_client)) {
        $google_client->revokeToken();
    }

    session_destroy();
    $conn = null;

    header('Location: ../../index.php');
    exit();
