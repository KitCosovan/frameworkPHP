<?php

define("ROOT", dirname(__DIR__));

const DEBUG = 1;
const ERROR_LOG_FILE = ROOT . '/tmp/error.log';

const WWW = ROOT . '/public';

const UPLOADS = WWW . '/uploads';

const CACHE = ROOT . '/tmp/cache';

const APP = ROOT . '/app';

const CONFIG = ROOT . '/config';

const CORE = ROOT . '/core';

const HELPERS = ROOT . '/helpers';

const VIEWS = APP . '/Views';
const LAYOUT = 'default';
const PATH = ''; //domain
CONST LOGIN_PAGE = PATH . '/login';

const DB = [
    'host' => '',
    'dbname' => '',
    'username' => '',
    'password' => '',
    'charset' => '',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];

const EMAIL = [
    'host' => '',
    'auth' => true,
    'username' => '',
    'password' => '',
    'secure' => null,
    'port' => 2525,
    'from-email' => '',
    'html' => true,
    'char-set' => 'UTF-8',
    'debug' => 0,
];
