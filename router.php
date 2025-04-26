<?php

require "auth.php"; // Include your authentication middleware

$routes = require "routes.php";

// Define which routes require authentication
$protectedRoutes = ['/', '/about', '/contact'];
// Define which routes are for guests only
$guestRoutes = ['/login', '/register'];

function routeToController($uri, $routes, $protectedRoutes, $guestRoutes) {
    if (array_key_exists($uri, $routes)) {
        // Check if this route needs authentication
        if (in_array($uri, $protectedRoutes)) {
            requireAuth(); // Will redirect to login if not authenticated
        }
        
        // Check if this route is for guests only
        if (in_array($uri, $guestRoutes)) {
            guest(); // Will redirect to home if already authenticated
        }
        
        require $routes[$uri];
    } else {
        http_response_code(404);
        require "views/404.php";
    }
}

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

routeToController($uri, $routes, $protectedRoutes, $guestRoutes);