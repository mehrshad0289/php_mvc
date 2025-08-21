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

        "categories" => ['controller' => 'app\controllers\CategoryController', 'method' => 'index'],
        "categories/create" => ['controller' => 'app\controllers\CategoryController', 'method' => 'create'],
        "categories/edit/([0-9]+)" => ['controller' => 'app\controllers\CategoryController', 'method' => 'edit'],

        "posts" => ['controller' => 'app\controllers\PostController', 'method' => 'index'],
        "posts/create" => ['controller' => 'app\controllers\PostController', 'method' => 'create'],
        "posts/edit/([0-9]+)" => ['controller' => 'app\controllers\PostController', 'method' => 'edit'],
        "posts/search" => ['controller' => 'app\controllers\PostController', 'method' => 'search'],

        "users/register" => ['controller' => 'app\controllers\UserController', 'method' => 'register'],
        "users/login-form" => ['controller' => 'app\controllers\UserController', 'method' => 'loginForm'],
        "users/logout" => ['controller' => 'app\controllers\UserController', 'method' => 'logout'],

    ],
    'POST' => [
        "categories/store" => ['controller' => 'app\controllers\CategoryController', 'method' => 'store'],
        "categories/update/([0-9]+)" => ['controller' => 'app\controllers\CategoryController', 'method' => 'update'],
        "categories/delete/([0-9]+)" => ['controller' => 'app\controllers\CategoryController', 'method' => 'delete'],

        "posts/store" => ['controller' => 'app\controllers\PostController', 'method' => 'store'],
        "posts/update/([0-9]+)" => ['controller' => 'app\controllers\PostController', 'method' => 'update'],
        "posts/delete/([0-9]+)" => ['controller' => 'app\controllers\PostController', 'method' => 'delete'],

        "users/store" => ['controller' => 'app\controllers\UserController', 'method' => 'store'],
        "users/login" => ['controller' => 'app\controllers\UserController', 'method' => 'login'],
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
