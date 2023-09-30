<?php

// Authentication routes
$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');

$router->get('/recover', 'registration/recover/create.php');
$router->post('/recover', 'registration/recover/store.php');
$router->get('/new-password', 'registration/recover/new-password.php');
$router->post('/register', 'registration/store.php')->only('guest');

// User routes
$router->get('/user', 'user.php')->only('auth');
$router->get('/following', 'following.php')->only('auth');
$router->get('/followers', 'followers.php')->only('auth');
$router->post('/changeUserData', 'changeUserData.php')->only('auth');

// Content routes
$router->get('/', 'index.php')->only('guest');
$router->get('/post', 'post.php')->only('auth');
$router->get('/home', 'home.php')->only('auth');
$router->get('/notifications', 'notifications.php')->only('auth');

// Settings routes
$router->get('/settings', 'settings.php')->only('auth');