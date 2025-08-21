<?php
session_start();

// Set error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_DIR', __DIR__);
define('URL_ROOT', "http://localhost/php-mvc-project");

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/Database.php"; 