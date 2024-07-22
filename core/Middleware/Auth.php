<?php

namespace PHPFramework\Middleware;

class Auth
{
    public function handle(): void
    {
        if (!check_auth()) {
            redirect('/login');
        }
    }
}
