<?php

require __DIR__ . "/../config/database.php";

$db = new DB();
$pdo = $db->getConnection();


$sql = "
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
)
";

$pdo->exec($sql);

echo "Notes table created successfully.";