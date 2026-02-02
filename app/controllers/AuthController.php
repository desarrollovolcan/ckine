<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\AuditLog;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login', ['title' => 'Ingreso']);
    }

    public function login(): void
    {
        $validator = new Validator();
        $email = Request::sanitize((string) Request::input('email'));
        $password = (string) Request::input('password');

        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }

        $validator->required('email', $email, 'Correo requerido.');
        $validator->required('password', $password, 'Contraseña requerida.');

        if ($validator->fails()) {
            $this->view('auth/login', ['title' => 'Ingreso', 'errors' => $validator->errors()]);
            return;
        }

        if (!Auth::attempt($email, $password)) {
            $this->view('auth/login', ['title' => 'Ingreso', 'errors' => ['general' => ['Credenciales inválidas.']]]);
            return;
        }

        $audit = new AuditLog();
        $audit->log($_SESSION['user_id'], 'login', 'auth', null, ['email' => $email]);

        if (!empty($_SESSION['must_change_password'])) {
            $this->redirect('/auth/password');
            return;
        }

        $this->redirect('/dashboard');
    }

    public function showChangePassword(): void
    {
        $this->view('auth/change-password', ['title' => 'Cambiar contraseña']);
    }

    public function changePassword(): void
    {
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $password = (string) Request::input('password');
        $confirm = (string) Request::input('password_confirmation');
        $validator->required('password', $password, 'Nueva contraseña requerida.');
        if ($password !== $confirm) {
            $validator->required('password_confirmation', null, 'Las contraseñas no coinciden.');
        }

        if ($validator->fails()) {
            $this->view('auth/change-password', ['title' => 'Cambiar contraseña', 'errors' => $validator->errors()]);
            return;
        }

        $userModel = new User();
        $userModel->updatePassword((int) $_SESSION['user_id'], password_hash($password, PASSWORD_DEFAULT));
        $_SESSION['must_change_password'] = false;
        $this->redirect('/dashboard');
    }

    public function logout(): void
    {
        $audit = new AuditLog();
        $audit->log($_SESSION['user_id'] ?? null, 'logout', 'auth', null, []);
        Auth::logout();
        $this->redirect('/auth/login');
    }
}
