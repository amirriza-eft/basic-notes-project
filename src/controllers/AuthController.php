<?php

class AuthController
{
    private $auth;
    private $user;
    private $pdo;

    public function __construct($auth, $user, $pdo)
    {
        $this->auth = $auth;
        $this->pdo = $pdo;
        $this->user = $user;
    }

    public function login()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $errors = [];

        if ($email === '') {
            $errors['email'] = "Email is required.";
        }

        if ($password === '') {
            $errors['password'] = "Password is required.";
        }

        if (empty($errors)) {
            $loggedUser = $this->user->login($email, $password);

            if ($loggedUser) {
                $_SESSION['user_id'] = $loggedUser['id'];
                $_SESSION['user_name'] = $loggedUser['full_name'];
                $_SESSION['user_email'] = $loggedUser['email'];

                if (isset($_POST['remember_me'])) {
                    createRememberToken(
                        $this->pdo,
                        $loggedUser['id']
                    );
                }

                header('Location: /');
                exit;

            } else {
                $errors[] = "Invalid email address.";
            }
        }

        $_SESSION['errors'] = $errors;

        header('Location: /?page=login');
        exit;
    }


    public function signup()
    {
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        $errors = [];

        if ($fullName === '') {
            $errors['full_name'] = "Full name is required.";
        } elseif (strlen($fullName) < 3) {
            $errors['full_name'] = "Full name must be at least 3 characters.";
        } elseif (strlen($fullName) > 100) {
            $errors['full_name'] = "Full name must be less than 30 characters.";
        }

        if ($email === '') {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email address.";
        }

        if ($password === '') {
            $errors['password'] = "Password is required.";
        }elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = "Password does not match.";
        }elseif (strlen($password) < 6) {
            $errors['password'] = "Password must be at least 6 characters.";
        }

        if (empty($errors)) {
            $existingUser = $this->user->findByEmail($email);

            if ($existingUser) {
                $errors['email'] = "Email already exists.";
            } else {

                $this->user->create($fullName, $email, $password);

                $_SESSION['message'] = 'Account created successfully. Please log in.';

                header('Location: /?page=login');
                exit;
            }
        }

        $_SESSION['errors'] = $errors;

        header('Location: /?page=signup');
        exit;
    }

    public function logout()
    {
        $this->auth->logout();

        header('Location: /?page=login');
        exit;
    }
}