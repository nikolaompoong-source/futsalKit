<?php

// 1. Dynamic BASE_URL Detection
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$subFolder = str_replace('\\', '/', dirname($scriptName));
if ($subFolder === '/') {
    $subFolder = '';
}
define('BASE_URL', $protocol . $domain . $subFolder);
define('APPROOT', __DIR__ . '/app');

// 2. Load Core Classes
require_once APPROOT . '/core/Database.php';
require_once APPROOT . '/core/Session.php';
require_once APPROOT . '/core/Controller.php';
require_once APPROOT . '/core/App.php';

// 3. Initialize Session & Alert System
Session::init();

// 4. Instantiate Custom Routing App
$app = new App();
