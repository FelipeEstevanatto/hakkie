<?php

namespace Http\Controllers;

use Core\Session;

class NotificationsController {
    public function index() {
        return view("notifications.view.php", [
            'heading' => 'Notifications',
            'errors' => Session::get('errors'),
        ]);
    }
}