<?php

namespace app\controllers;

use app\models\Category;
use app\views\Viewer;

class CategoryController extends AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new Category();
    }

    public function index()
    {
        $this->authorize();

        $categories = $this->model->getCategories();

        $viewer = new Viewer();
        $viewer->render("/categories/index.php", ['categories' => $categories]);
    }

    public function create()
    {
        $this->authorize();

        $viewer = new Viewer();
        $viewer->render("/categories/create.php");
    }

    public function store($data)
    {
        $this->authorize();

        $title = trim($data['title']);

        $errors = [];
        if (empty($title)) {
            $errors += ['title' => 'Title is required'];
        }

        if (empty($errors)) {

            try {
                $this->model->createCategory($title);
                redirect("/categories", ['success' => 'Category created successfully']);
            } catch (\PDOException $ex) {
                redirect("/categories/create", ['error' => 'Category creation failed']);
            }
        } else {
            redirect("/categories/create", ['form_errors' => $errors]);
        }
    }

    public function edit($id)
    {
        $this->authorize();

        $category = $this->model->getCategory($id);

        $viewer = new Viewer();
        if (empty($category)) {
            $viewer->render("/errors/404.php");
            exit;
        }
        $viewer->render("/categories/edit.php", ['category' => $category]);
    }

    public function update($data, $id)
    {
        $this->authorize();

        $title = trim($data['title']);

        $errors = [];
        if (empty($title)) {
            $errors += ['title' => 'Title is required'];
        }

        if (empty($errors)) {
            $category = $this->model->getCategory($id);
            if (empty($category)) {
                $viewer = new Viewer();
                $viewer->render("/errors/404.php");
                exit;
            }
            $this->model->updateCategory($id, $title);
            redirect("/categories", ['success' => 'Category updated successfully']);
        } else {
            redirect("/categories/edit/$id", ['form_errors' => $errors]);
        }
    }

    public function delete($data, $id)
    {
        $this->authorize();
        
        $category = $this->model->getCategory($id);

        $viewer = new Viewer();
        if (empty($category)) {
            $viewer->render("/errors/404.php");
            exit;
        }
        $this->model->deleteCategory($id);
        redirect("/categories", ['success' => 'Category deleted successfully']);
    }
}
