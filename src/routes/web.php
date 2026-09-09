<?php

$routes = array(
    '/' => 'home.php',
    'login' => 'login.php',
    'signup' => 'signup.php',
);

function route($uri)
{
    global $routes;

    if (isset($routes[$uri])) {
        include __DIR__ . '/../pages/' . $routes[$uri];
        return;
    }

    http_response_code(404);
    echo '404 Page Not Found';
}