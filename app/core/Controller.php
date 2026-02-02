<?php
namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $path): void
    {
        $app = require __DIR__ . '/../../config/app.php';
        $baseUrl = rtrim($app['base_url'], '/');
        if (!str_starts_with($path, 'http')) {
            $path = $baseUrl . '/' . ltrim($path, '/');
        }
        header('Location: ' . $path);
        exit;
    }
}
