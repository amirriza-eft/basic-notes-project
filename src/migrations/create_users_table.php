<?php

require __DIR__ . "/../config/database.php";

 const HOST = "php81_dev_environment_database";
 const DB = "php81_dev_environment";
 const USER = "root";
 const PASSWORD = "1234";

$pdo = new PDO(
    "mysql:host=" . HOST .
    ";dbname=" . DB .
    ";charset=utf8mb4",
    USER,
    PASSWORD
);

$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);


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
