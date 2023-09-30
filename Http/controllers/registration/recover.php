<?php

namespace Http\controllers;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require base_path('app/php/' . 'recoverLogic.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    view("recover.view.php", [
        'heading' => 'Recover',
    ]);
}

