<?php

session_start();

require_once __DIR__ . '/classes/Auth.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/check_remember_token.php';
require_once __DIR__ . '/helpers/remember_token.php';
require_once __DIR__ . '/policies/NotePolicy.php';

require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Note.php';


$db = new DB();
$pdo = $db->getConnection();

$auth = new Auth($pdo);
$note = new Note($pdo);
$user = new User($pdo);

checkRememberToken($pdo);

require_once __DIR__ . '/controllers/NoteController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . "/routes/web.php";

route(
    $_GET['page'] ?? "/",
    $pdo,
    $auth
);