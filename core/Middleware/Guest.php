<?php

namespace PHPFramework\Middleware;

class Guest
{
    public function handle(): void
    {
        if (check_auth()) {
            redirect('/');
        }
    }
}
