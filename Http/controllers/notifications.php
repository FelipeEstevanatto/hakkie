<?php

namespace Http\controllers;

use Core\Session;

view("notifications.view.php", [
    'heading' => 'Notifications',
    'errors' => Session::get('errors'),
]);