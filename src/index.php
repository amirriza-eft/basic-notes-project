<?php

session_start();

require_once __DIR__ . '/classes/Auth.php';

$auth = new Auth();

require_once __DIR__ . "/routes/web.php";
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Note.php';


route($_GET['page'] ?? "/");