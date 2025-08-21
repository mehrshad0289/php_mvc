<?php
namespace app\controllers;

use app\views\Viewer;

class HomeController
{
    public function index()
    {
        $title = "Welcome";

        $viewer = new Viewer();
        $viewer->render('/home/index.php', ['title' => $title]);
    }
}
