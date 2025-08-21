<?php

namespace app\controllers;

use app\models\User;
use app\views\Viewer;

class UserController extends AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function register()
    {
        $viewer = new Viewer();
        $viewer->render('/users/register.php');
    }

    public function store($data)
    {
        $email = trim($data['email']);
        $password = trim($data['password']);
        $confirm_password = trim($data['confirm_password']);

        $errors = [];
        if (empty($email)) {
            $errors += ['email' => 'Email is required'];
        }

        if (empty($password)) {
            $errors += ['password' => 'Password is required'];
        } elseif (strlen($password) < 6) {
            $errors += ['password' => 'Password must be more than 6 characters'];
        }

        if (empty($confirm_password)) {
            $errors += ['confirm_password' => 'Confirm Password is required'];
        } elseif ($password != $confirm_password) {
            $errors += ['confirm_password' => 'confirm password does not match'];
        }

        if (empty($errors)) {

            if ($this->model->getUserByEmail($email)) {
                $errors += ['email' => 'Email already exists'];
                redirect("/users/register", ['form_errors' => $errors]);
            }

            try {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->model->createUser($email, $hashedPassword);
                redirect("/users/login-form", ['success' => 'User created successfully, Please log in']);
            } catch (\PDOException $ex) {
                redirect("/users/register", ['error' => 'User creation failed']);
            }
        } else {
            redirect("/users/register", ['form_errors' => $errors]);
        }
    }

    public function loginForm()
    {
        $viewer = new Viewer();
        $viewer->render('/users/login.php');
    }

    public function login($data)
    {
        $email = trim($data['email']);
        $password = trim($data['password']);

        $errors = [];
        if (empty($email)) {
            $errors += ['email' => 'Email is required'];
        }

        if (empty($password)) {
            $errors += ['password' => 'Password is required'];
        }

        if (empty($errors)) {

            $user = $this->model->getUserByEmail($email);

            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;

                redirect("/", ['success' => 'You have successfully logged in']);
            } else {
                redirect("/users/login-form", ['error' => 'Invalid email or password']);
            }
        } else {
            redirect("/users/login-form", ['form_errors' => $errors]);
        }
    }

    public function profile()
    {
        $this->authorize();

        $user = $this->model->getUserByEmail($_SESSION['user_email']);
        $viewer = new Viewer();
        $viewer->render('/users/profile.php', ['user' => $user]);
    }



    public function updateProfileAndImage($data)
    {
        $this->authorize();
        $user = $this->model->getUserByEmail($_SESSION['user_email']);

        $email = trim($data['email']);

        if ($_FILES['image']['size'] > 0) {
            $image = $_FILES['image'];
            print_r($image);
            $imageName = generateFileName($image['name']);
            $imagePath = BASE_DIR . '/public/uploads/' . $imageName;
            move_uploaded_file($image['tmp_name'], $imagePath);
            $image = URL_ROOT . '/public/uploads/' . $imageName;
        }
        $errors = [];
        if (empty($email)) {
            $errors += ['email' => 'Email is required'];
        }

        // if (empty($image)) {
        //     $errors += ['image' => 'Image is required'];
        // }

        if (empty($errors)) {
            $this->model->updateUser($user->id, $email, $image);
            // _SESSION update email
            $_SESSION['user_email'] = $email;
            // _SESSION update image
            $_SESSION['user_image'] = $image;
            redirect("/users/profile", ['success' => 'Profile updated successfully']);
        } else {
            redirect("/users/profile", ['form_errors' => $errors]);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        session_destroy();

        redirect("/users/login-form");
    }



    public function index()
    {
        $sort_date = $_GET['sort_date'] ?? '';
        $sort_email = $_GET['sort_email'] ?? '';

        $this->authorize();
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $usersPerPage = 2;

        $users = $this->model->getUsers($currentPage, $usersPerPage, $sort_date, $sort_email);
        $totalUsers = $this->model->getTotalUsers();
        $totalPages = ceil($totalUsers / $usersPerPage);

        $viewer = new Viewer();
        $viewer->render("/users/list.php", ['users' => $users, 'currentPage' => $currentPage, 'totalPages' => $totalPages]);
    }
    public function search()
    {
        $this->authorize();
        $query = $_GET['query'] ?? '';

        $users = [];
        if(!empty($query)) {
            $users = $this->model->searchUsers($query);
        }

        $viewer = new Viewer();
        $viewer->render("/users/search.php", ['users' => $users]);
    }
    public function getUserByEmail($email)
    {
        return $this->model->getUserByEmail($email);
    }
}
