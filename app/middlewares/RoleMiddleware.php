<?php

declare(strict_types=1);

class RoleMiddleware
{
    private array $config;
    private Database $db;

    public function __construct(array $config, Database $db)
    {
        $this->config = $config;
        $this->db = $db;
    }

    public function handle(string $role): void
    {
        $user = Auth::user();
        if (!$user || ($user['role'] ?? '') !== $role) {
            header('Location: /');
            exit;
        }
    }
}
