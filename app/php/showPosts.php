<?php

function showPosts($conn, $user, $posts, $choosenId = '') {
    require_once(__DIR__."/functions.php");

    $session_user = decodeId($_SESSION['idUser']);

    $query = 'SELECT username, picture, auth_type,
              EXISTS (SELECT user_blocked FROM blocks WHERE (fk_user = :id AND user_blocked = :session_user) OR (fk_user = :session_user AND user_blocked = :id)) AS blocked,
              EXISTS (SELECT * FROM follows WHERE fk_user = :session_user AND user_followed = :id) AS following
              FROM users WHERE id = :id';

    $stmt = $conn -> prepare($query);
    $stmt -> bindValue(':id', $user);
    $stmt -> bindValue(':session_user', $session_user);
    $stmt -> bindValue(':session_user', $session_user);
    $stmt -> bindValue(':id', $user);
    $stmt -> bindValue(':session_user', $session_user);
    $stmt -> bindValue(':id', $user);
    $stmt -> bindValue(':id', $user);
    $stmt -> execute();

    $return = $stmt -> fetch(PDO::FETCH_ASSOC);

    if ($return['blocked']) return;

    $username = $return['username'];
    $userpicture = $return['picture'];
    $following_status = $return['following'] ? 'Unfollow' : 'Follow';
    $permitedVideoFormats = array("webm","mp4","mov");
    
    $isGoogle = ($return['auth_type'] == "GOOGLE") ? true : false;

    if ( count($return) > 0) { 
        //Coalesce returns 0 instead of null, so we don't need an if
        $query = 'SELECT id, content, date, fk_owner,
                        (SELECT COUNT(file_name) FROM files WHERE fk_owner = fk_owner AND fk_post = id) AS post_media,
                        COALESCE((SELECT COUNT(likes.id) FROM likes WHERE fk_post = id GROUP BY fk_post),0) AS post_likes,
                        COALESCE((SELECT COUNT(comments.id) FROM comments WHERE fk_post = id GROUP BY fk_post),0) AS post_comments,
                        (SELECT COUNT(*) FROM likes WHERE fk_post = id AND fk_like_owner = :session_user ) AS already_liked
                  FROM posts WHERE fk_owner = :id'; 
        if (!empty($choosenId) && !is_float(decodeId(cleanString($choosenId))) ) {
            $query .= ' AND id = :choosen_id';
        }
        $query .=' ORDER BY date DESC';

        $stmt = $conn -> prepare($query);

        $stmt -> bindValue(':id', $user);
        $stmt -> bindValue(':session_user', $session_user);
        $stmt -> bindValue(':id', $user);
        
        if (!empty($choosenId) && !is_float(decodeId(cleanString($choosenId))) ) {
            $stmt -> bindValue(':choosen_id', decodeId(cleanString($choosenId)));
        }

        $stmt -> execute();

        $returnPosts = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        foreach ($returnPosts as $key=>$post) {
            if ($key >= $posts) break;

            if ($post['post_media'] > 0) {
                $query = 'SELECT file_name, file_type, fk_post FROM files WHERE fk_owner = :id AND fk_post = :post_id';
                $stmt = $conn -> prepare($query);
                $stmt -> bindValue(':id', $user);
                $stmt -> bindValue(':post_id', $post['id']);
                $stmt -> execute();
                $returnMedia = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            }

            //================== Start of post DIV ================== (with post id and user id)
            $actual_post = '<!--Post layout-->
            <div class="post text" id="'.encodeId($post['id']).'">
                <div class="top-post">
                    <div class="left" id="'.encodeId($user).'">
                        <img src="';
                        //================== User Picture and name ==================
                        if ($isGoogle) {
                            $actual_post.=$userpicture;
                        } elseif ($userpicture != NULL) {
                            $actual_post.= $GLOBALS['base_url'] . '/../profiles/'.$userpicture;
                        } else {
                            $actual_post.= $GLOBALS['base_url'] . '/../public/images/defaultUser.png'; //fallback
                        }
                        $actual_post.='">
                        <a href="user?user='.encodeId($user).'">'.$username.'</a>
                    </div>
                    
                    <div class="right">
                        <span>'
                        .time_elapsed_string($post['date']).'
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
                if ($post['content'] != 'NULL') {
                $actual_post.='<div class="content-post">
                                    '.convertYoutube($post['content']).'
                            </div>';
                }
                //================== Post Media ==================
                if ($post['post_media'] > 0) {
                    foreach ($returnMedia as $filesPost) {

                        $temparray = explode(".",$filesPost["file_name"]);
                        $extension = strtolower(end($temparray));

                        if ( in_array($extension , $permitedVideoFormats) ) {
                            $actual_post.='<video width="100%" controls style="border-radius: 5%;">
                                <source src="../posts/'.$filesPost["file_name"].'" type="video/'.$extension.'" >
                                Your browser do not support the video tag
                            </video>';
                        } else {
                            if (file_exists(substr(__DIR__,0,-7).'public\posts\\'.$filesPost["file_name"])) {
                                $actual_post.='<img src="../posts/'.$filesPost["file_name"].'" alt="'.$filesPost["file_name"];
                            } else {
                                $actual_post.='<img src="../images/lost-image.png" alt="'.$filesPost["file_name"];
                            }
                            $actual_post.='" style="border-radius: 5%; margin: 10px 0; width:100%;">';
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