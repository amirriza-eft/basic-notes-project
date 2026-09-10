<?php


function createRememberToken($pdo, $userId)
{
    $selector = bin2hex(random_bytes(16));

    $token = bin2hex(random_bytes(32));

    $hash = password_hash(
        $token,
        PASSWORD_DEFAULT
    );

    $expires = date(
        "Y-m-d H:i:s",
        time() + (60 * 60 * 24 * 30)
    );

    $sql = "
        INSERT INTO remember_tokens
        (
            user_id,
            selector,
            token_hash,
            expires_at
        )
        VALUES
        (?, ?, ?, ?)
    ";

    $query = $pdo->prepare($sql);

    $query->execute([
        $userId,
        $selector,
        $hash,
        $expires
    ]);

    setcookie(
        "remember_me",
        $selector . ":" . $token,
        [
            "expires" => time() + (60 * 60 * 24 * 30),
            "httponly" => true,
            "samesite" => "Lax"
        ]
    );
}