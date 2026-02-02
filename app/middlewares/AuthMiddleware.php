<?php
namespace App\Middlewares;

use App\Core\Auth;
use App\Core\View;

class AuthMiddleware
{
    public function handle(): void
    {
        if (!Auth::check()) {
            header('Location: /auth/login');
            exit;
        }
    }
}
