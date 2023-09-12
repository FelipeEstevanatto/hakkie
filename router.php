<?php
session_start();

// Define the base URL for your application
$base_url = 'http://localhost/hakkie/';
$GLOBALS['base_url'] = $base_url;

// Define the routes
$routes = [
    'hakkie' => 'index.php',
    '' => 'index.php',
    'settings' => 'public/views/settings.php',
    'login' => 'public/views/login.php',
    'user' => 'public/views/user.php',
    'post' => 'public/views/post.php',
    'home' => 'public/views/home.php',
    'notifications' => 'public/views/notifications.php',
    'about' => 'public/views/about.php',
    'contact' => 'public/views/contact.php',
    'api/users' => 'api/users.php',
    'api/posts' => 'api/posts.php',
    'loginLogic' => 'app/php/loginLogic.php',
    'logout' => 'app/php/logout.php',
    'changeUserData' => 'app/php/changeUserData.php',
    'postLogic' => 'app/php/posts/postLogic.php',
    'deletePost' => 'app/php/posts/deletePost.php',
    'likeLogic' => 'app/php/posts/likeLogic.php',
    'post' => 'public/views/post.php',
    'followLogic' => 'app/php/followLogic.php',
    'blockingLogic' => 'app/php/blockingLogic.php',
    'new-password' => 'public/views/new-password.php',
    'recover' => 'public/views/recover.php',
    'recoverLogic' => 'app/php/recoverLogic.php',
    'following' => 'public/views/following.php',
    'followers' => 'public/views/followers.php',
    'changePasswordDB' => 'app/php/changePasswordDB.php',
];

// Get the requested URL
$url = $_SERVER['REQUEST_URI'];

// Get the query string parameters
$queryString = $_GET;

// Get the base name of the URL without the query string
$path = parse_url($url, PHP_URL_PATH);
$basename = $path ? basename($path) : '';

// Route the request to the appropriate PHP file or function
if (isset($routes[$basename])) {
    require __DIR__ . DIRECTORY_SEPARATOR . $routes[$basename];
} else {
    http_response_code(404);
    echo '404 Not Found';
    exit();
}