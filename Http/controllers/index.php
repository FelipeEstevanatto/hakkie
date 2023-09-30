<?php

namespace Http\controllers;

use Core\Session;

view("index.view.php", [
    'heading' => 'Home',
    'errors' => Session::get('errors'),
    'old' => Session::get('old'),
]);