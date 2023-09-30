<?php

namespace Core\Middleware;

class Authenticated
{
    public function handle()
    {
        // If the user is not logged in, redirect to the login page.
        if (! $_SESSION['user'] ?? false) {
            header('location: /hakkie');
            exit();
        }
    }
}