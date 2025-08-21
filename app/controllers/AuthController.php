<?php

namespace app\controllers;

class AuthController
{
    protected function authorize()
    {
        if (!isLoggedIn()) {
            redirect('/users/login-form', ['error' => 'You do not have permission to access this page, Please log in']);
        } 
    }
}
