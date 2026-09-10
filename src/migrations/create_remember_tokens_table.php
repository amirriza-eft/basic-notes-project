<?php

require __DIR__ . "/../config/database.php";

$db = new DB();
$pdo = $db->getConnection();

$sql = "
    CREATE TABLE IF NOT EXISTS remember_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        selector VARCHAR(64) NOT NULL UNIQUE,
        token_hash VARCHAR(255) NOT NULL,
        expires_at DATETIME NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )
";

$pdo->exec($sql);

echo "Remember tokens table created successfully.";