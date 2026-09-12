<?php

$routes = array(
    '/' => 'home.php',
    'login' => 'login.php',
    'signup' => 'signup.php',
    'logout' => 'logout.php',
);

function route($uri, $pdo, $auth)
{
    global $routes;

    if (isset($routes[$uri])) {
        include __DIR__ . '/../pages/' . $routes[$uri];
        return;
    }

    http_response_code(404);
    echo '404 Page Not Found';
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'POST' && $uri === '/login') {
    $controller = new AuthController($auth, $user, $pdo);
    $controller->login();
}

if ($method === 'POST' && $uri === '/signup') {
    $controller = new AuthController($auth, $user, $pdo);
    $controller->signup();
}

if ($method === 'POST' && $uri === '/logout') {
    $controller = new AuthController($auth, $user, $pdo);
    $controller->logout();
}


if ($method === 'POST' && $uri === '/notes/create') {
    $controller = new NoteController($auth, $note);
    $controller->store();
}

if ($method === 'POST' && $uri === '/notes/update') {
    $controller = new NoteController($auth, $note);
    $controller->update();
}

if ($method === 'POST' && $uri === '/notes/delete') {
    $controller = new NoteController($auth, $note);
    $controller->delete();
}