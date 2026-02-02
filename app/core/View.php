<?php
namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException('View not found: ' . $view);
        }
        include __DIR__ . '/../views/layouts/main.php';
    }

    public static function renderPartial(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException('View not found: ' . $view);
        }
        include $viewPath;
    }
}
