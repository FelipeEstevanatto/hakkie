<?php

function showPosts($user, $posts, $tab) {

    require("../../app/database/connect.php");
    require_once("functions.php");

    $user = intval($user);

    $query = "SELECT name_user, user_picture, auth_type FROM users WHERE id_user = :id_user";

    $stmt = $conn -> prepare($query);

    $stmt -> bindValue(':id_user', $user);

    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    $username = $return['name_user'];
    $userpicture = $return['user_picture'];
    
    if ($return['auth_type'] == "GOOGLE") {
        $isGoogle = true;
    } else {
        $isGoogle = false;
    }

    if ( count($return) > 0) {
        //$query = 'SELECT COUNT(fk_like_owner) FROM likes WHERE fk_post = 12 AND fk_like_owner = 8'
        $query = 'SELECT fk_post, fk_like_owner
                  FROM likes WHERE fk_like_owner = :id_user';
        $stmt = $conn -> prepare($query);
        $stmt -> bindValue(':id_user', $user);
        $stmt -> execute();
        $likes = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
        $query = "SELECT id_post, post_text, post_media, post_likes, post_comments, post_date, fk_owner FROM posts WHERE fk_owner = :id_user ORDER BY post_date DESC";

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':id_user', $user);

        $stmt -> execute();

        $return = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        foreach ($return as $key=>$post) {
            if ($key >= $posts) break;
            if (isset($post['post_media']) && $post['post_media'] != 'NULL') {

                $path = $_SERVER['DOCUMENT_ROOT']."/hakkie/public/profiles/".$post['post_media'];
                //If file exists in database but not in the folder
                if (!file_exists($path)) {

                    $query = "UPDATE posts SET post_media = 'NULL' WHERE post_media = '".$post['post_media']."' AND fk_owner = ".$_SESSION['idUser'];

                    $stmt = $conn -> query($query);

                    $altImage = "Image lost :(";
                }
            }

            $actual_post = '<!--Post layout-->
            <div class="post text" id="post_id'.$post['id_post'].'">
                <div class="top-post">
                    <div class="left">
                        
                        <img src="';
                        //================== User Picture and name ==================
                        if ($isGoogle) {
                            $actual_post.=$userpicture;
                        } elseif ($userpicture != NULL) {
                            $actual_post.='../profiles/'.$userpicture;
                        } else {//fallback
                            $actual_post.='../images/defaultUser.png';
                        }
                        $actual_post.='">
                        <a href="user.php?user='.$user.'">'.$username.'</a>
                    </div>
                    
                    <div class="right">
                        <span>'.substr($post['post_date'],0,16).'
                        <i class="fas fa-ellipsis-v" class="interative-form-btn"></i>
                        </span>

                        <div class="interative-form close">
                            <div class="btn-form" id="follow">Follow User</div>
                            <div class="btn-form" id="block">Block User</div>';
                            if ($post['fk_owner'] == $_SESSION['idUser'])
                                $actual_post.='<div class="btn-form" id="delete">Delete Post</div>';
                        $actual_post.='
                        </div>
                    </div>
                </div>';
                //================== Post Text ==================
                if ($post['post_text'] != 'NULL') {
                $actual_post.='<div class="content-post">
                                    '.$post['post_text'].'
                            </div>';
                }
                //================== Post Media ==================
                if ($post['post_media'] != 'NULL') {
                    if (substr($post['post_media'],-4) == '.mp4') {
                        $actual_post.='<video width="100%" controls style="border-radius: 5%;">
                            <source src="../profiles/'.$post['post_media'].'" type="video/mp4" >
                            Your browser do not support the video tag
                        </video>';
                    } else {
                        $actual_post.='<img src="../profiles/'.$post['post_media'].'" ';
                        if (isset($altImage)) {
                            $actual_post.='alt="'.$altImage.'"';
                        }
                        $actual_post.='style="border-radius: 5%; margin: 10px 0; width:100%;">';
                    } 
                }
                //================== Post Footer ==================
                $alreadyliked = '';
                foreach($likes as $i) {
                    if ($i['fk_post'] == $post['id_post']) {
                        $alreadyliked = ' class="my-like" ';
                    }
                }

                $actual_post.='
                <div class="bottom-post">
                    <div class="list">
                        <div class="tab" id="tab-like">
                            <i class="fas fa-thumbs-up"></i>
                            <span'.$alreadyliked.'>'.$post['post_likes'].' Likes</span>
                        </div>
                        <div class="tab" id="tab-comment">
                            <i class="fas fa-comment"></i>
                            <span>'.$post['post_comments'].' Comments</span>
                        </div>
                        <div class="tab" id="tab-share">
                            <i class="fas fa-share-square"></i>
                            <span>Share</span>
                        </div>
                    </div>
                </div>
            </div>';
            
            echo$actual_post;
        }
        
    } else {
        echo"This user doesn't exist, so he doesn't have posts";
    }

}