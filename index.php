<?php

use Core\Session;
use Core\ValidationException;
use Core\Router;

const BASE_PATH = __DIR__.'/';

session_start();

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'Core/functions.php';
require BASE_PATH . 'bootstrap.php';

$router = new Router();
require BASE_PATH . 'routes.php';

$uri = str_replace('/hakkie', '', parse_url($_SERVER['REQUEST_URI'])['path']);
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

define('DEFAULT_THEME', 'dark');

try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old);

    return redirect($router->previousUrl());
}

Session::unflash();