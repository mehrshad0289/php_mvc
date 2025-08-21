<?php

namespace app\controllers;

use app\models\Category;
use app\models\Post;
use app\views\Viewer;

class PostController extends AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new Post();
    }

    public function index()
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $postsPerPage = 5;

        $posts = $this->model->getPosts($currentPage, $postsPerPage);
        $totalPosts = $this->model->getTotalPosts();
        $totalPages = ceil($totalPosts/$postsPerPage);

        $viewer = new Viewer();
        $viewer->render("/posts/index.php", ['posts' => $posts, 'currentPage' => $currentPage, 'totalPages' => $totalPages]);
    }

    public function search()
    {
        $query = $_GET['query'] ?? '';

        $posts = [];
        if(!empty($query)) {
            $posts = $this->model->searchPosts($query);
        }

        $viewer = new Viewer();
        $viewer->render("/posts/search.php", ['posts' => $posts]);
    }

    public function create()
    {
        $this->authorize();

        $categoryModel = new Category();
        $categories = $categoryModel->getCategories();

        $viewer = new Viewer();
        $viewer->render("/posts/create.php", ['categories' => $categories]);
    }

    public function store($data)
    {
        $this->authorize();

        $title = trim($data['title']);
        $body = trim($data['body']);
        $category_id = trim($data['category_id']);

        $errors = [];
        if (empty($title)) {
            $errors += ['title' => 'Title is required'];
        }
        if (empty($body)) {
            $errors += ['body' => 'Body is required'];
        }
        if (empty($category_id)) {
            $errors += ['category_id' => 'Category id is required'];
        }

        if (empty($errors)) {

            try {
                $this->model->createPost($title, $body, $category_id);
                redirect("/posts", ['success' => 'Post created successfully']);
            } catch (\PDOException $ex) {
                redirect("/posts/create", ['error' => 'Post creation failed']);
            }
        } else {
            redirect("/posts/create", ['form_errors' => $errors]);
        }
    }

    public function edit($id)
    {
        $this->authorize();

        $post = $this->model->getPost($id);

        $viewer = new Viewer();
        if (empty($post)) {
            $viewer->render("/errors/404.php");
            exit;
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getCategories();

        $viewer = new Viewer();
        $viewer->render("/posts/edit.php", ['post' => $post, 'categories' => $categories]);
    }

    public function update($data, $id)
    {
        $this->authorize();

        $title = trim($data['title']);
        $body = trim($data['body']);
        $category_id = trim($data['category_id']);

        $errors = [];
        if (empty($title)) {
            $errors += ['title' => 'Title is required'];
        }
        if (empty($body)) {
            $errors += ['body' => 'Body is required'];
        }
        if (empty($category_id)) {
            $errors += ['category_id' => 'Category id is required'];
        }

        if (empty($errors)) {

            $this->model->updatePost($id, $title, $body, $category_id);
            redirect("/posts", ['success' => 'Post updated successfully']);
        } else {
            redirect("/posts/edit/$id", ['form_errors' => $errors]);
        }
    }

    public function delete($data, $id)
    {
        $this->authorize();
        
        $post = $this->model->getPost($id);

        $viewer = new Viewer();
        if (empty($post)) {
            $viewer->render("/errors/404.php");
            exit;
        }
        $this->model->deletePost($id);
        redirect("/posts", ['success' => 'Post deleted successfully']);
    }
}
