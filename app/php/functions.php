<?php

function cleanString($string) {
    return filter_var(htmlspecialchars(trim($string),FILTER_SANITIZE_STRING));
}

function cleanEmail($string) {
    $string = trim(strtolower(filter_var($string,FILTER_SANITIZE_EMAIL)));
    if (strlen($string) < 256 && !empty($string)) {
        return $string;
    } else {
        return false;
    }
}

function generateFakePassword() {
    return password_hash(random_bytes(32), PASSWORD_BCRYPT);
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

function encodeId($num, $b=62) {
    //Multiply by 1024, pass to dex, revert and pass to base 62
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
}
