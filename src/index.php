<?php

session_start();

require_once __DIR__ . "/routes/web.php";

route($_GET['page'] ?? "/");