<?php

// Authentication routes
$router->get('/login', 'session/SessionController@create')->only('guest');
$router->post('/session', 'session/SessionController@store')->only('guest');
$router->delete('/session', 'session/SessionController@destroy')->only('auth');
$router->get('/login/google', 'session/SessionController@google')->only('guest');
$router->get('/login/google/callback', 'session/SessionController@create')->only('guest');

$router->get('/recover', 'registration/recover/create');
$router->post('/recover', 'registration/recover/store');
$router->get('/new-password', 'registration/recov/new-password');
$router->post('/register', 'registration/RegistrationController@store')->only('guest');

// User routes
$router->get('/user', 'UserController@index')->only('auth');
$router->get('/following', 'FollowingController@index')->only('auth');
$router->get('/followers', 'FollowersController@index')->only('auth');
$router->post('/changeUserData', 'UserController@edit')->only('auth');

// Content routes
$router->get('/', 'IndexController@index');//->only('guest');
$router->get('/post', 'post/PostController@view')->only('auth');
$router->post('/post', 'post/PostController@store')->only('auth');
$router->post('/post/delete', 'post/PostController@destroy')->only('auth');
$router->get('/home', 'HomeController@index')->only('auth');
$router->get('/notifications', 'NotificationsController@index')->only('auth');
$router->post('/like', 'post/LikeController@like')->only('auth');
$router->post('/unlike', 'post/LikeController@unlike')->only('auth');

// Settings routes
$router->get('/settings', 'SettingsController@index')->only('auth');