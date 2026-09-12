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
}