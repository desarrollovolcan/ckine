<?php
namespace App\Middlewares;

use App\Core\Auth;

class RoleMiddleware
{
    private string $permission;

    public function __construct(string $permission = '')
    {
        $this->permission = $permission;
    }

    public function handle(): void
    {
        if (!$this->permission) {
            return;
        }
        if (!Auth::hasPermission($this->permission)) {
            http_response_code(403);
            echo 'Acceso denegado';
            exit;
        }
    }
}
