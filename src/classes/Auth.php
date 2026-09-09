<?php

class Auth
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    public function check()
    {
        return isset($_SESSION['user_id']);
    }


    public function id()
    {
        return $_SESSION['user_id'] ?? null;
    }


    public function fullName()
    {
        return $_SESSION['user_name'] ?? '';
    }


    public function email()
    {
        return $_SESSION['user_email'] ?? '';
    }


    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: /?page=login");
        exit;
    }

}