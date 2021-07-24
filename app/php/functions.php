<?php

function cleanString($string) {
    return filter_var(trim($string),FILTER_SANITIZE_STRING);
}

function cleanEmail($string) {
    return trim(strtolower(filter_var($string,FILTER_SANITIZE_EMAIL)));
}

function generateFakePassword() {
    return password_hash(random_bytes(16), PASSWORD_BCRYPT);
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
