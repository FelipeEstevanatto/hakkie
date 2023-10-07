<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;

class HomeController {
    public function index() {
        $db = App::resolve(Database::class);
        
        $users = $db->query('SELECT DISTINCT users.id FROM users INNER JOIN posts ON fk_owner = users.id')->get();
        include(__DIR__ . "../post/showPosts.php");

        return view("home.view.php", [
            'heading' => 'Home',
            'users' => $users,
        ]);
    }
}