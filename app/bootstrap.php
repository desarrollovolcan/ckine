<?php
declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (str_starts_with($class, $prefix)) {
        $relative = str_replace('App\\', '', $class);
        $path = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
});

$app = require __DIR__ . '/../config/app.php';

date_default_timezone_set($app['timezone']);

set_exception_handler(function (Throwable $exception) use ($app): void {
    http_response_code(500);
    $errorMessage = $exception->getMessage();
    include __DIR__ . '/views/errors/500.php';
});
