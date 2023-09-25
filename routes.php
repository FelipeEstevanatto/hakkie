<?php

// Authentication routes
$router->get('/login', 'login.php');
$router->post('/login', 'login.php');
$router->get('/recover', 'recover.php');
$router->post('/recover', 'recover.php');
$router->get('/new-password', 'new-password.php');
$router->post('/registerLogic', 'registerLogic.php');
$router->get('/logout', 'logout.php');

// User routes
$router->get('/user', 'user.php');
$router->get('/following', 'following.php');
$router->get('/followers', 'followers.php');
$router->post('/changeUserData', 'changeUserData.php');

// Content routes
$router->get('/', 'index.php');
$router->get('/post', 'post.php');
$router->get('/home', 'home.php');

// Settings routes
$router->get('/settings', 'settings.php');