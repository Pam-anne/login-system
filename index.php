<?php


// Simple router
$route = $_SERVER['REQUEST_URI'];


$uri = parse_url($route, PHP_URL_PATH);

if ($uri === '/') {
    require __DIR__ . '/controllers/index.php';
} elseif ($uri === '/about') {
    require __DIR__ . '/controllers/about.php';
} elseif ($uri === '/contact') {
    require __DIR__ . '/controllers/contact.php';
} elseif ($uri === '/login') {
    require __DIR__ . '/controllers/login/login.php';
} elseif ($uri === '/logout') {
    require __DIR__ . '/controllers/login/logout.php';
} elseif ($uri === '/register') {
    require __DIR__ . '/controllers/registration/register.php';
} else {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
