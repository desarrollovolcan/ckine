<?php

declare(strict_types=1);

class BaseController
{
    protected array $config;
    protected Database $db;

    public function __construct(array $config, Database $db)
    {
        $this->config = $config;
        $this->db = $db;
    }

    protected function render(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        extract($data);
        $config = $this->config;
        $currentUser = Auth::user();
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        $layoutPath = __DIR__ . '/../views/' . $layout . '.php';
        if (!file_exists($layoutPath)) {
            throw new RuntimeException('Layout no encontrado');
        }
        include $layoutPath;
    }

    protected function renderPublic(string $view, array $data = []): void
    {
        $this->render($view, $data, 'layouts/public');
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    protected function requireLogin(): void
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
    }

    protected function requireRole(string $role): void
    {
        $user = Auth::user();
        if (!$user || ($user['role'] ?? '') !== $role) {
            $this->redirect('/');
        }
    }
}
