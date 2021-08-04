<?php

function showPosts($user, $posts, $tab) {

    include("../../app/database/connect.php");
    include("functions.php");
    
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
        
        $query = "SELECT post_text, post_media, post_likes, post_date FROM posts WHERE fk_owner = :id_user ORDER BY post_date DESC";

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

            $actual_post='<div class="post text">
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
                        <a href="#">'.$username.'</a>
                    </div>
                    
                    <div class="right">
                        <span>';

                            $actual_post.=substr($post['post_date'],0,16);

                        $actual_post.=' 
                        <i class="fas fa-ellipsis-v"></i>
                        </span>
                        
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
                    $actual_post.='<img src="../profiles/'.$post['post_media'].'" ';
                    if (isset($altImage)) {
                        $actual_post.='alt="'.$altImage.'"';
                    }
                    $actual_post.='style="border-radius: 5%; margin: 10px 0; width:100%;">';
                }
                $actual_post.='
                <div class="bottom-post">
                    <div class="list">
                        <div class="tab">
                            <i class="fas fa-thumbs-up"></i>
                            <span>'.$post['post_likes'].' Likes</span>
                        </div>
                        <div class="tab">
                            <i class="fas fa-comment"></i>
                            <span>0 Comments</span>
                        </div>
                        <div class="tab">
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