<?php
require __DIR__ . '/app/bootstrap.php';

$routes = require __DIR__ . '/app/routes.php';

if (!isset($_GET['route'])) {
    if (Auth::check()) {
        header('Location: index.php?route=dashboard');
    } else {
        header('Location: index.php?route=auth/login');
    }
    exit;
}

$route = (string)$_GET['route'];
$publicRoutes = [
    'auth/login',
    'auth/login/submit',
];

if (!Auth::check() && !in_array($route, $publicRoutes, true)) {
    header('Location: index.php?route=auth/login');
    exit;
}

if (!isset($routes[$route])) {
    http_response_code(404);
    $controller = new ErrorController($config, $db);
    $controller->notFound();
    exit;
}

if (Auth::check() && !can_access_route($db, $route, Auth::user())) {
    http_response_code(403);
    $controller = new ErrorController($config, $db);
    $controller->forbidden();
    exit;
}

[$controllerName, $method] = $routes[$route];
try {
    $controller = new $controllerName($config, $db);
    $controller->$method();
} catch (Throwable $e) {
    log_message('error', sprintf('Route %s failed: %s', $route, $e->getMessage()));
    http_response_code(500);
    include __DIR__ . '/error-500.php';
    exit;
}
