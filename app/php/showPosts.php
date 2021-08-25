<?php

function showPosts($user, $posts, $choosenId = '') {

    require("../../app/database/connect.php");
    require_once("functions.php");

    $session_user = decodeId($_SESSION['idUser']);

    $query = 'SELECT name_user, user_picture, auth_type,
              EXISTS (SELECT user_blocked FROM blocks WHERE (fk_user = :id_user AND user_blocked = :session_user) OR (fk_user = :session_user AND user_blocked = :id_user)) AS blocked,
              EXISTS (SELECT * FROM follows WHERE fk_user = :session_user AND user_followed = :id_user) AS following
              FROM users WHERE id_user = :id_user';

    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id_user', $user);
    $stmt -> bindValue(':session_user', $session_user);
    $stmt -> bindValue(':session_user', $session_user);
    $stmt -> bindValue(':id_user', $user);
    $stmt -> bindValue(':session_user', $session_user);
    $stmt -> bindValue(':id_user', $user);
    $stmt -> bindValue(':id_user', $user);
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($return['blocked']) return;

    $username = $return['name_user'];
    $userpicture = $return['user_picture'];
    $following_status = $return['following'] ? 'Unfollow' : 'Follow';
    
    $isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;

    if ( count($return) > 0) { 
        //Coalesce returns 0 instead of null, so we don't need an if
        $query = 'SELECT id_post, post_text, post_date, fk_owner,
                        (SELECT COUNT(file_name) FROM files WHERE fk_owner = fk_owner AND fk_post = id_post) AS post_media,
                        COALESCE((SELECT COUNT(id_like) FROM likes WHERE fk_post = id_post GROUP BY fk_post),0) AS post_likes,
                        COALESCE((SELECT COUNT(id_comment) FROM comments WHERE fk_post = id_post GROUP BY fk_post),0) AS post_comments,
                        (SELECT COUNT(*) FROM likes WHERE fk_post = id_post AND fk_like_owner = :session_user ) AS already_liked
                  FROM posts WHERE fk_owner = :id_user'; 
        if (!empty($choosenId) && !is_float(decodeId(cleanString($choosenId))) ) {
            $query .= ' AND id_post = :choosen_id';
        }
        $query .=' ORDER BY post_date DESC';

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':id_user', $user);
        $stmt -> bindValue(':session_user', $session_user);
        $stmt -> bindValue(':id_user', $user);
        
        if (!empty($choosenId) && !is_float(decodeId(cleanString($choosenId))) ) {
            $stmt -> bindValue(':choosen_id', decodeId(cleanString($choosenId)));
        }

        $stmt -> execute();

        $returnPosts = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        foreach ($returnPosts as $key=>$post) {
            if ($key >= $posts) break;

            if ($post['post_media'] > 0) {
                $query = 'SELECT file_name, file_type, fk_post FROM files WHERE fk_owner = :id_user AND fk_post = :post_id';
                $stmt = $conn -> prepare($query);
                $stmt -> bindValue(':id_user', $user);
                $stmt -> bindValue(':post_id', $post['id_post']);
                $stmt -> execute();
                $returnMedia = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            }

            //================== Start of post DIV ================== (with post_id and user_id)
            $actual_post = '<!--Post layout-->
            <div class="post text" id="'.encodeId($post['id_post']).'">
                <div class="top-post">
                    <div class="left" id="'.encodeId($user).'">
                        <img src="';
                        //================== User Picture and name ==================
                        if ($isGoogle) {
                            $actual_post.=$userpicture;
                        } elseif ($userpicture != NULL) {
                            $actual_post.='../profiles/'.$userpicture;
                        } else {
                            $actual_post.='../images/defaultUser.png'; //fallback
                        }
                        $actual_post.='">
                        <a href="user.php?user='.encodeId($user).'">'.$username.'</a>
                    </div>
                    
                    <div class="right">
                        <span>'
                        .time_elapsed_string($post['post_date']).'
                        <i class="fas fa-ellipsis-v" class="interative-form-btn"></i>
                        </span>

                        <div class="interative-form close">';
                            if ($post['fk_owner'] != decodeId($_SESSION['idUser'])) {
                                $actual_post.='
                                <div class="btn-form '.$following_status.'" id="follow">'.$following_status.' User</div>
                                <div class="btn-form" id="block">Block User</div>';
                            } else {
                                $actual_post.='<div class="btn-form" id="delete">Delete Post</div>';
                            }
                        $actual_post.='
                        </div>
                    </div>
                </div>';
                //================== Post Text ==================
                if ($post['post_text'] != 'NULL') {
                $actual_post.='<div class="content-post">
                                    '.convertYoutube($post['post_text']).'
                            </div>';
                }
                //================== Post Media ==================
                if ($post['post_media'] > 0) {
                    foreach ($returnMedia as $filesPost) {
                        if (substr($filesPost["file_name"],-4) == '.mp4') {
                            $actual_post.='<video width="100%" controls style="border-radius: 5%;">
                                <source src="../posts/'.$filesPost["file_name"].'" type="video/mp4" >
                                Your browser do not support the video tag
                            </video>';
                        } else {
                            $actual_post.='<img src="../posts/'.$filesPost["file_name"].'" ';
                            if (isset($altImage)) {
                                $actual_post.='alt="'.$altImage.'"';
                            }
                            $actual_post.='style="border-radius: 5%; margin: 10px 0; width:100%;">';
                        }
                    }
                }
                //================== Post Footer ==================
                if ($post['already_liked'] == 1) {
                    $alreadyliked = ' my-like';
                } else {
                    $alreadyliked = '';
                }

                $actual_post.='
                <div class="bottom-post">
                    <div class="list">
                        <div class="tab'.$alreadyliked.'" id="tab-like">
                            <i class="fas fa-thumbs-up"></i>
                            <span>'.$post['post_likes'].' Likes</span>
                        </div>
                        <div class="tab" id="tab-comment">
                            <i class="fas fa-comment"></i>
                            <span>'.$post['post_comments'].'<span class="text">Comments</span></span>
                        </div>
                        <div class="tab" id="tab-share">
                            <i class="fas fa-share-square"></i>
                            <span><span class="text">Share</span></span>
                        </div>
                    </div>
                </div>
            </div>';
            //================== End of Post Footer ==================

            echo$actual_post;
        }

    } else {
        echo"This user doesn't exist, so he doesn't have posts";
    }

    return;
}