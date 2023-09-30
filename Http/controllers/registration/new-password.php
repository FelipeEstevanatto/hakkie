<?php

namespace Http\controllers;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require base_path('app/php/' . 'recoverLogic.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $valid = false;

    if (isset($_GET['selector']) && isset($_GET['validator']) && (isset($_GET['newpdw']) && $_GET['newpwd'] != 'error') ) {
        $valid = true;
    }

    $message = '';
    if ( isset($_GET['newpwd']) && $_GET['newpwd'] == 'checkyouremail' )
        $message = "Check your email for the recovery link (look in the Spam tab too)";  
    elseif (!$valid) {
        $message = "It was not possible to validade your request";
    } elseif (isset($_GET['newpwd']) && $_GET['newpwd'] == 'pwdnotsame')
        $message = "Put the same password in both fields!";

    view("new-password.view.php", [
        'heading' => 'Recover',
        'valid' => $valid,
        'message' => $message,
    ]);
}

