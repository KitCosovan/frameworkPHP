<?php

/** @var \PHPFramework\Application $app */

const MIDDLEWARE = [
    'auth' => \PHPFramework\Middleware\Auth::class,
    'guest' => \PHPFramework\Middleware\Guest::class,
];

$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);
