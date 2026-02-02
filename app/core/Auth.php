<?php
namespace App\Core;

use App\Models\User;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        $userModel = new User();
        return $userModel->find((int) $_SESSION['user_id']);
    }

    public static function attempt(string $email, string $password): bool
    {
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['must_change_password'] = (bool) $user['must_change_password'];
        session_regenerate_id(true);
        return true;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function hasPermission(string $permissionKey): bool
    {
        if (!self::check()) {
            return false;
        }
        $roleId = (int) $_SESSION['role_id'];
        $userModel = new User();
        return $userModel->roleHasPermission($roleId, $permissionKey);
    }
}
