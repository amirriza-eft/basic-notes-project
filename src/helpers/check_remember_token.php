<?php


function checkRememberToken($pdo)
{
    if (isset($_SESSION['user_id'])) {
        return;
    }

    if (!isset($_COOKIE['remember_me'])) {
        return;
    }

    $cookie = explode(':', $_COOKIE['remember_me']);

    if (count($cookie) !== 2) {
        return;
    }

    $selector = $cookie[0];
    $token = $cookie[1];

    $query = $pdo->prepare("
        SELECT *
        FROM remember_tokens
        WHERE selector = ?
        AND expires_at > NOW()
        LIMIT 1
    ");

    $query->execute([
        $selector
    ]);

    $remember = $query->fetch(PDO::FETCH_ASSOC);

    if (!$remember) {
        return;
    }

    if (!password_verify($token, $remember['token_hash'])) {
        return;
    }

    $query = $pdo->prepare("
        SELECT *
        FROM users
        WHERE id = ?
        LIMIT 1
    ");

    $query->execute([
        $remember['user_id']
    ]);

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_email'] = $user['email'];

}