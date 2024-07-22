<?php

define("ROOT", dirname(__DIR__));
// Определение константы ROOT, которая содержит путь к корневой директории проекта

const DEBUG = 1;
const ERROR_LOG_FILE = ROOT . '/tmp/error.log';

const WWW = ROOT . '/public';
// Определение константы WWW, которая содержит путь к директории public

const UPLOADS = WWW . '/uploads';

const CACHE = ROOT . '/tmp/cache';

const APP = ROOT . '/app';
// Определение константы APP, которая содержит путь к директории app

const CONFIG = ROOT . '/config';
// Определение константы CONFIG, которая содержит путь к директории config

const CORE = ROOT . '/core';
// Определение константы CORE, которая содержит путь к директории core

const HELPERS = ROOT . '/helpers';
// Определение константы HELPERS, которая содержит путь к директории helpers

const VIEWS = APP . '/Views';
const LAYOUT = 'default';
const PATH = ''; //domain
CONST LOGIN_PAGE = PATH . '/login';

/* const DB = [
    'host' => '127.127.126.50',
    'dbname' => 'zenblog',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
]; */

/* const EMAIL = [
    'host' => 'sandbox.smtp.mailtrap.io',
    'auth' => true,
    'username' => '17962bec0b78e0',
    'password' => '091f43e76cd7d2',
    'secure' => null,
    'port' => 2525,
    'from-email' => '1b58a0db5-29c0e8@inbox.mailtrap.io',
    'html' => true,
    'char-set' => 'UTF-8',
    'debug' => 0,
]; */
