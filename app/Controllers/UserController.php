<?php

namespace App\Controllers;

use App\Models\User;
use App\Validation\Validator;

class UserController extends Controller {
    public function login() {
        return $this->view('auth.login');
    }

    public function loginPost() {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'username' => ['required', 'min:3'],
            'password' => ['required']
        ]);

        if($errors) {
            $_SESSION['errors'][] = $errors;
            header('location: /login');
            die();
        }

        $user = new User($this->getDB());
        $user = $user->getByUsername($_POST['username']);

        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['auth'] = (int)$user->admin;
            return header('location: /admin/posts?connect=true');
        } else {
            header('location: /login');
        }
    }

    public function logout() {
        session_destroy();

        header('location: /');
    }
}