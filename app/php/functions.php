<?php

function cleanString($string) {
    return trim($string);
}

function generateFakePassword() {
    return password_hash("something", PASSWORD_BCRYPT);
}

function getUserIP() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null;
    }

    return $ip;
}