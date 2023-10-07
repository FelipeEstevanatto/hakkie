<?php

namespace Http\Controllers\post;

use Core\App;
use Core\Session;
use Core\Database;
use Core\ValidationException;
use Http\Forms\PostForm;

class PostController {
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

        //dd($return);
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
        $db = App::resolve(Database::class);
        date_default_timezone_set('America/Sao_Paulo');

        $form = new PostForm([
            'post-text' => $_POST['post-text'],
        ]);

        $sessionID = $_SESSION['user']['id'];

        $errors = $form->validateForm()->errors();

        if ($form->hasErrors()) {
            ValidationException::throw($errors, $_POST);
            redirect('user?user=' . $sessionID);
            exit();
        }

        if(count($_FILES["uploadfile"]['name']) > 4){
            header("location: user?user=".$sessionID."&error=toomuchfiles");
            exit();
        }

        // if (empty($_FILES["uploadfile"]["tmp_name"][0])) {
        //     header("Location: user?user=".$sessionID);
        //     exit();   
        // }

        $db->query('INSERT INTO posts(content, fk_owner) VALUES(:content, :id)', [
            'content' => $_POST['post-text'],
            'id' => $sessionID
        ]);  

        $return = $db->query('SELECT id FROM posts WHERE fk_owner = :id ORDER BY id DESC LIMIT 1', [
            'id' => $sessionID
        ])->find();

        $postId = $return["id"];

        if (isset($_FILES) && !empty($_FILES["uploadfile"]["tmp_name"])) {

            // File extension verification ====================================
            $permitedFormats = array("jpg","png","jpeg","webm","mp4","mov","gif");
            $renamed = Array();
            $extensions = Array();

            foreach ($_FILES['uploadfile']['type'] as $filestype) {
                
                $temparray = explode("/",$filestype);
                $extension = strtolower(end($temparray));

                if ( !in_array( $extension , $permitedFormats ) ) {
                    header("location: user?user=".$sessionID."&error=fileformat");
                    exit;
                }

                array_push($renamed, $sessionID.'Upload'.date('Ymd').(100*rand(0,100000)).".".$extension);
                array_push($extensions, $extension);
            }

            // File sizes verification ====================================
            foreach ($_FILES['uploadfile']['size'] as $filessize) {
                if ( $filessize >= 33554432 ) { //32Mb max size
                    header("Location: user?user=".$sessionID."&error=bigfile");
                    exit();
                }
            }

            $folder = str_replace("\\", '/',substr(__DIR__,0,-13))."public/posts/";

            foreach ($_FILES['uploadfile']['tmp_name'] as $key => $filestempname) {

                if (!move_uploaded_file($filestempname, $folder.$renamed[$key])) {
                    header("Location: user?user=".$sessionID."&error=failedupload");
                    exit();
                }
            }
            
            //Insert in table
            foreach ($renamed as $key => $imagename) {
                $db->query('INSERT INTO files(file_name, file_type, fk_post, fk_owner) VALUES(:file_name, :file_type, :fk_post, :session_user)', [
                    'file_name' => $imagename,
                    'file_type' => $extensions[$key],
                    'fk_post' => $postId,
                    'session_user' => $sessionID
                ]);
            }
            
            echo"tudo certo";
        } 

        if ($postId > 0) {
            header("Location: user?user=".$sessionID);
            exit();

        } else {
            header("Location: user?user=".$sessionID."&error=dberror");
            exit();
        }

    }
}