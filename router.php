<?php


$uri  = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'controllers/index.php',
    '/about' => 'controllers/about.php',
    '/contact' => 'controllers/contact.php',
    '/login' => 'controllers/login/login.php',
    '/logout' => 'controllers/login/logout.php',
    '/register' => 'controllers/registration/register.php'
];



function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        http_response_code(404);
        require "views/404.php";
    }
}

routeToController($uri, $routes);