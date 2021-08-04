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
