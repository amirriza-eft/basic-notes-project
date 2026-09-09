<?php

require __DIR__ . "/../config/database.php";

$db = new DB();
$pdo = $db->getConnection();

$sql = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
";

$pdo->exec($sql);

echo "Users table created successfully.";
