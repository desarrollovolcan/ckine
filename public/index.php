<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/../config/app.php';
$dbConfig = require __DIR__ . '/../config/db.php';

$GLOBALS['config'] = $config;

date_default_timezone_set($config['timezone'] ?? 'UTC');

require __DIR__ . '/../app/helpers.php';
require __DIR__ . '/../app/core/Database.php';
require __DIR__ . '/../app/core/Model.php';
require __DIR__ . '/../app/core/Auth.php';
require __DIR__ . '/../app/core/Validator.php';
require __DIR__ . '/../app/core/Router.php';
require __DIR__ . '/../app/core/BaseController.php';
require __DIR__ . '/../app/middlewares/AuthMiddleware.php';
require __DIR__ . '/../app/middlewares/RoleMiddleware.php';

spl_autoload_register(function (string $class): void {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});

$db = Database::getInstance($dbConfig);

$router = new Router($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
$routes = require __DIR__ . '/../app/routes/web.php';

foreach ($routes as $route) {
    $router->register($route['method'], $route['path'], $route['handler'], $route['middleware'] ?? []);
}

$router->dispatch($config, $db);
