<?php

namespace Http\Controllers;

use Core\Session;

class IndexController {
    public function index() {
        $google_uri = $_ENV['GOOGLE_LOGIN_URI'] ?? null;
        $google_client_id = $_ENV['GOOGLE_CLIENT_ID'] ?? null;

        return view("index.view.php", [
            'heading' => 'Home',
            'errors' => Session::get('errors'),
            'old' => Session::get('old'),
            'google_uri' => $google_uri,
            'google_client_id' => $google_client_id
        ]);
    }
}
