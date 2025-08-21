<?php

use app\views\Viewer;

require __DIR__ . "/../bootstrap.php";

// for develop localhost
$path = trim(str_replace("php-mvc-project/", "", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), "/");
// for deploy
// $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) , "/");

// print_r($path);

$routes = [
    'GET' => [
        "" => ['controller' => 'app\controllers\HomeController', 'method' => 'index'],
        "users/register" => ['controller' => 'app\controllers\UserController', 'method' => 'register'],
        "users/login-form" => ['controller' => 'app\controllers\UserController', 'method' => 'loginForm'],
        "users/logout" => ['controller' => 'app\controllers\UserController', 'method' => 'logout'],
        "users/profile" => ['controller' => 'app\controllers\UserController', 'method' => 'profile'],
        "users/list" => ['controller' => 'app\controllers\UserController', 'method' => 'index'],
        "users/search" => ['controller' => 'app\controllers\UserController', 'method' => 'search'],
    ],
    'POST' => [
        "users/store" => ['controller' => 'app\controllers\UserController', 'method' => 'store'],
        "users/login" => ['controller' => 'app\controllers\UserController', 'method' => 'login'],
        "users/update-profile-and-image" => ['controller' => 'app\controllers\UserController', 'method' => 'updateProfileAndImage'],
    ]
];

$method = $_SERVER['REQUEST_METHOD'];
foreach ($routes[$method] as $route => $info) {

    if (preg_match("#^$route$#", $path, $matches)) {

        $id = $matches[1] ?? null;
        $controller = new $info['controller'];

        if ($method === 'POST') {
            $controller->{$info['method']}($_POST, $id);
        } else {
            $controller->{$info['method']}($id);
        }

        break;
    }
}

if (!isset($controller)) {
    $viewer = new Viewer();
    $viewer->render('/errors/404.php');
}
