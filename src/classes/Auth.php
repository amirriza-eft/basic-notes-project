<?php

class Auth
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

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
        if (isset($_COOKIE['remember_me'])) {

            $parts = explode(':', $_COOKIE['remember_me']);

            if (count($parts) === 2) {
                $selector = $parts[0];

                $query = $this->pdo->prepare("
                DELETE FROM remember_tokens
                WHERE selector = ?
            ");
                $query->execute([
                    $selector
                ]);
            }
        }

        setcookie(
            'remember_me',
            '',
            [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        session_unset();
        session_destroy();

        header("Location: /?page=/");
        exit;
    }

}