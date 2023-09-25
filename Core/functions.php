<?php

use Core\Response;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition) {
        abort($status);
    }

    return true;
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    require base_path('views/' . $path);
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}

function old($key, $default = '')
{
    return Core\Session::get('old')[$key] ?? $default;
}

function getUserIP() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null;
    }

    $ipDetails = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    
    if ( $ip == '::1') {
        $ipDetails->ip = 'Localhost';
    }

    return $ipDetails;
}


function generateFakePassword() {
    return password_hash(random_bytes(32), PASSWORD_BCRYPT);
}

function encodeId($num, $b=62) {
    //Multiply by 32768, and pass to base 62
    $num = $num * 32768;
    $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $r = $num  % $b ;
    $res = $base[$r];
    $q = floor($num/$b);
    while ($q) {
        $r = $q % $b;
        $q =floor($q/$b);
        $res = $base[$r].$res;
    }
    return $res;
}
    
function decodeId($num, $b=62) {
    $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $limit = strlen($num);
    $res = strpos($base,$num[0]);
    for($i=1;$i<$limit;$i++) {
        $res = $b * $res + strpos($base,$num[$i]);
    }
    return $res / 32768; 
}

function convertYoutube($string) {
    if (preg_match("/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",$string))
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "<br><iframe width=\"100%\" height=\"100%\" src=\"//www.youtube.com/embed/$2\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe><br>",
        $string
    );
    else return $string;
}

function time_elapsed_string($datetime, $full = false) {
    date_default_timezone_set('America/Sao_Paulo');

    $now = time();
    $ago = strtotime($datetime);
    $diff = $now - $ago;

    $intervals = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'min',
        1 => 'sec'
    );

    $string = '';
    foreach ($intervals as $seconds => $label) {
        $count = floor($diff / $seconds);
        if ($count > 0) {
            $string .= $count . ' ' . $label . ($count > 1 ? 's' : '') . ', ';
            $diff -= $count * $seconds;
        }
    }

    $string = trim($string, ', ');
    if (!$full) {
        $string = explode(', ', $string)[0];
    }

    return $string ? $string . ' ago' : 'just now';
}

function joinedSince($timestamp) {

    $time = substr($timestamp, 5, 2);   
    $months = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    ];

    return $months[$time]." of ".substr($timestamp, 0, 4); 
}
