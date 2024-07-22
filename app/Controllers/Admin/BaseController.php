<?php

namespace App\Controllers\Admin;

use PHPFramework\Controller;

class BaseController extends Controller
{
    public string $layout = 'admin';

    public function __construct()
    {
        if (!check_admin()) {
            redirect('/');
        }
    }
}
