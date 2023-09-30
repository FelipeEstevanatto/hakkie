<?php

namespace Core\Middleware;

class Guest
{
    public function handle()
    {
        // If the user is logged in, redirect to the home page.
        if ($_SESSION['user'] ?? false) {
            header('location: home');
            exit();
        }
    }
}