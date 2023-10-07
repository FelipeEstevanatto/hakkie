<?php

namespace Http\Controllers\post;

use Core\Session;
use Core\App;
use Core\Database;

class BlockController {

    private $db = null;

    public function __construct() {
        $this->db = App::resolve(Database::class);
    }

    public function block() {
        $return = $this->db->query('INSERT INTO blocks VALUES(DEFAULT, :user_blocked, DEFAULT, :fk_user); DELETE FROM follows WHERE user_followed = :user_blocked AND fk_user = :fk_user;',[
            'user_blocked' => $_POST['block'],
            'fk_user' => $_SESSION['user']['id'],
            'user_blocked' => $_POST['block'],
            'fk_user' => $_SESSION['user']['id']
        ]);
    
        if ($return) {
            echo"1";
        } else {
            echo"0";
        }
    }

    public function unblock() {
        $return = $this->db->query('DELETE FROM blocks WHERE user_blocked = :id_blocked AND fk_user = :session_user', [
            'id_blocked' => $_POST['unblock'],
            'session_user' => $_SESSION['user']['id']
        ]);
    
        if ($return) {
            echo"1";
        } else {
            echo"0";
        }
    }
}
