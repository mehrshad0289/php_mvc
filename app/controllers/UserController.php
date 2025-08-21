<?php
namespace app\controllers;

use app\models\User;
use app\views\Viewer;

class UserController
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

            try{
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->model->createUser($email, $hashedPassword);
                redirect("/users/login-form", ['success' => 'User created successfully, Please log in']);
            }catch(\PDOException $ex) {
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

            if($user && password_verify($password, $user->password)) {
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

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        session_destroy();
        
        redirect("/users/login-form");
    }
}
