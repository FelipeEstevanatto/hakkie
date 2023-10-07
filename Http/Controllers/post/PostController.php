<?php

namespace Http\Controllers\post;

use Core\App;
use Core\Session;
use Core\Database;
use Core\ValidationException;
use Http\Forms\PostForm;

class PostController {

    private $db = null;
    private $sessionID = null;

    public function view() {
        $db = App::resolve(Database::class);

        if ( !isset($_GET['id']) || !is_numeric($_GET['id'])) {
            //This user does not exist in DB!
            view("user-blocked.view.php", [
                'heading' => 'User blocked',
            ]);
            exit();      
        }

        $post = $_GET['id'];

        $return = $db->query("SELECT user_blocked FROM blocks WHERE fk_user = :id", [
            'id' => $post
        ])->find();

        if ($return != null) {

            $return = $db->query("SELECT user_blocked FROM blocks WHERE user_blocked = :id", [
                'id' => $post
            ])->find();
            // If session user blocked this user or this user blocked session user
            $details = $return['user_blocked'] == $_SESSION['user']['id'] ? 'own_block' : 'blocked';

            view("user-blocked.view.php", [
                'heading' => 'User blocked',
                'details' => $details,
            ]);
            exit();
        }

        $return = $db->query("SELECT users.id FROM users INNER JOIN posts ON posts.fk_owner = users.id WHERE posts.id = :id", [
            'id' => $post
        ])->find();

        $id = $return['id'];
        include(__DIR__ . "/showPosts.php");
        view("post.view.php", [
            'heading' => 'Post',
            'id' => $id,
            'post' => $post,
            
        ]);
    }

    public function store() {
        $this->db = App::resolve(Database::class);
        date_default_timezone_set('America/Sao_Paulo');

        $form = new PostForm([
            'post-text' => $_POST['post-text'],
            'uploadfile' => $_FILES['uploadfile'] ?? null
        ]);
        
        $this->sessionID = $_SESSION['user']['id'];

        $errors = $form->validateForm()->errors();
        if ($form->hasErrors()) {
            ValidationException::throw($errors, $_POST);
            redirect('user?user=' . $this->sessionID);
            exit();
        }

        $this->db->query('INSERT INTO posts(content, fk_owner) VALUES(:content, :id)', [
            'content' => $_POST['post-text'],
            'id' => $this->sessionID
        ]);

        $return = $this->db->query('SELECT id FROM posts WHERE fk_owner = :id ORDER BY id DESC LIMIT 1', [
            'id' => $this->sessionID
        ])->find();

        $postId = $return["id"];

        
        if (isset($_FILES["uploadfile"]["tmp_name"]) && !empty($_FILES["uploadfile"]["tmp_name"][0])) {
            $this->upload($postId);
        } 
        
        if ($postId > 0) {
            header("Location: user?user=".$this->sessionID);
            exit();

        } else {
            ValidatorException::throw(['post-text' => ['The post-text field must be filled.']], $_POST);
            header("Location: user?user=".$this->sessionID);
            exit();
        }

    }

    public function upload($postId) { 
        // check if the file is less than 4 files ====================================
        if (count($_FILES['uploadfile']['name']) > 4) {
            ValidationException::throw(['uploadfile' => ['The uploadfile field must be less than 4 files.']], $_POST);
            header("location: user?user=".$this->sessionID);
            exit;
        }

        // File extension verification ====================================
        $permitedFormats = array("jpg","png","jpeg","webm","mp4","mov","gif");
        $renamed = Array();
        $extensions = Array();

        foreach ($_FILES['uploadfile']['type'] as $filestype) {
            
            $temparray = explode("/",$filestype);
            $extension = strtolower(end($temparray));

            if ( !in_array( $extension , $permitedFormats ) ) {
                ValidationException::throw(['uploadfile' => ['The uploadfile field must be an image or video.']], $_POST);
                header("location: user?user=".$this->sessionID);
                exit;
            }

            array_push($renamed, $this->sessionID.'_Upload'.date('Ymd').(100*rand(0,100000)).".".$extension);
            array_push($extensions, $extension);
        }

        // File sizes verification ====================================
        foreach ($_FILES['uploadfile']['size'] as $filessize) {
            if ( $filessize >= 33554432 ) { //32Mb max size
                ValidatorException::throw(['uploadfile' => ['The uploadfile field must be less than 32Mb.']], $_POST);
                header("Location: user?user=".$this->sessionID."&error=bigfile");
                exit();
            }
        }
        
        $folder = str_replace("\\", '/',substr(__DIR__,0,-21))."public/posts/";
        foreach ($_FILES['uploadfile']['tmp_name'] as $key => $filestempname) {
            //dd($filestempname);

            if (!move_uploaded_file($filestempname, $folder.$renamed[$key])) {
                $error = error_get_last();
                ValidatorException::throw(['uploadfile' => ['The uploadfile failed to upload.']], $_POST);
                header("Location: user?user=".$this->sessionID);
                exit();
            }
        }
        
        //Insert in table
        foreach ($renamed as $key => $imagename) {
            $this->db->query('INSERT INTO files(file_name, file_type, fk_post, fk_owner) VALUES(:file_name, :file_type, :fk_post, :session_user)', [
                'file_name' => $imagename,
                'file_type' => $extensions[$key],
                'fk_post' => $postId,
                'session_user' => $this->sessionID
            ]);
        }
    }
}