<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($method === 'GET' && $uri === '/login') {
    include __DIR__ . '/../pages/login.php';
    exit;
}
if ($method === 'GET' && $uri === '/signup') {
    include __DIR__ . '/../pages/signup.php';
    exit;
}
if ($method === 'POST' && $uri === '/login') {
    $controller = new AuthController($auth, $user, $pdo);
    $controller->login();
    exit;
}
if ($method === 'POST' && $uri === '/signup') {
    $controller = new AuthController($auth, $user, $pdo);
    $controller->signup();
    exit;
}
if ($method === 'POST' && $uri === '/logout') {
    $controller = new AuthController($auth, $user, $pdo);
    $controller->logout();
    exit;
}



if ($method === 'GET' && $uri === '/') {
    $controller = new NoteController($auth, $note);
    $controller->index();
    exit;
}

if ($method === 'GET' && $uri === '/notes/search') {
    $controller = new NoteController($auth, $note);
    $controller->search();
    exit;
}
if ($method === 'POST' && $uri === '/notes/create') {
    $controller = new NoteController($auth, $note);
    $controller->store();
    exit;
}
if ($method === 'POST' && $uri === '/notes/update') {
    $controller = new NoteController($auth, $note);
    $controller->update();
    exit;
}
if ($method === 'POST' && $uri === '/notes/delete') {
    $controller = new NoteController($auth, $note);
    $controller->delete();
    exit;
}

http_response_code(404);
echo '404 Page Not Found';