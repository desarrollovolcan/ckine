<?php

declare(strict_types=1);

class AuthPortalController extends BaseController
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/');
        }
        $this->render('auth/login', [
            'title' => 'Ingreso',
            'pageTitle' => 'Ingreso',
        ], 'layouts/auth');
    }

    public function login(): void
    {
        verify_csrf();
        $email = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        $users = new UserModel($this->db);
        $user = $users->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            flash('error', 'Credenciales inválidas.');
            $this->redirect('/login');
        }

        Auth::login([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'] ?? '',
            'role_id' => $user['role_id'],
            'must_change_password' => (bool)$user['must_change_password'],
        ]);

        if ((bool)$user['must_change_password']) {
            $this->redirect('/password');
        }

        $this->redirect('/');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }

    public function changePassword(): void
    {
        $this->requireLogin();
        $this->render('auth/change-password', [
            'title' => 'Cambiar contraseña',
            'pageTitle' => 'Cambiar contraseña',
        ]);
    }

    public function updatePassword(): void
    {
        $this->requireLogin();
        verify_csrf();

        $password = (string)($_POST['password'] ?? '');
        $confirm = (string)($_POST['password_confirm'] ?? '');

        if (strlen($password) < 8) {
            flash('error', 'La contraseña debe tener al menos 8 caracteres.');
            $this->redirect('/password');
        }
        if ($password !== $confirm) {
            flash('error', 'Las contraseñas no coinciden.');
            $this->redirect('/password');
        }

        $user = Auth::user();
        if (!$user) {
            $this->redirect('/login');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->db->execute('UPDATE users SET password_hash = :hash, must_change_password = 0 WHERE id = :id', [
            'hash' => $hash,
            'id' => $user['id'],
        ]);

        flash('success', 'Contraseña actualizada.');
        $this->redirect('/');
    }
}
