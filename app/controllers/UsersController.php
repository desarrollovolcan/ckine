<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;

class UsersController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('users.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $users = (new User())->all();
        $this->view('users/index', ['title' => 'Usuarios', 'users' => $users]);
    }

    public function create(): void
    {
        $this->authorize();
        $roles = (new Role())->all();
        $this->view('users/create', ['title' => 'Nuevo usuario', 'roles' => $roles]);
    }

    public function store(): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $name = Request::sanitize((string) Request::input('name'));
        $email = Request::sanitize((string) Request::input('email'));
        $roleId = (int) Request::input('role_id');
        $password = (string) Request::input('password');
        $validator->required('name', $name, 'Nombre requerido.');
        $validator->required('email', $email, 'Email requerido.');
        $validator->email('email', $email, 'Email inválido.');
        $validator->required('password', $password, 'Contraseña requerida.');
        if ($validator->fails()) {
            $roles = (new Role())->all();
            $this->view('users/create', ['title' => 'Nuevo usuario', 'roles' => $roles, 'errors' => $validator->errors()]);
            return;
        }

        $userModel = new User();
        $id = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role_id' => $roleId,
            'must_change_password' => 0,
            'is_active' => 1,
        ]);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'users', $id, ['email' => $email]);
        $this->redirect('/users');
    }

    public function edit(string $id): void
    {
        $this->authorize();
        $user = (new User())->find((int) $id);
        $roles = (new Role())->all();
        $this->view('users/edit', ['title' => 'Editar usuario', 'user' => $user, 'roles' => $roles]);
    }

    public function update(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $name = Request::sanitize((string) Request::input('name'));
        $email = Request::sanitize((string) Request::input('email'));
        $roleId = (int) Request::input('role_id');
        $mustChange = Request::input('must_change_password') ? 1 : 0;
        $isActive = Request::input('is_active') ? 1 : 0;
        $validator->required('name', $name, 'Nombre requerido.');
        $validator->required('email', $email, 'Email requerido.');
        $validator->email('email', $email, 'Email inválido.');
        if ($validator->fails()) {
            $roles = (new Role())->all();
            $this->view('users/edit', ['title' => 'Editar usuario', 'user' => (new User())->find((int) $id), 'roles' => $roles, 'errors' => $validator->errors()]);
            return;
        }
        (new User())->update((int) $id, [
            'name' => $name,
            'email' => $email,
            'role_id' => $roleId,
            'must_change_password' => $mustChange,
            'is_active' => $isActive,
        ]);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'update', 'users', (int) $id, ['email' => $email]);
        $this->redirect('/users');
    }

    public function delete(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/users');
            return;
        }
        (new User())->delete((int) $id);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'delete', 'users', (int) $id, []);
        $this->redirect('/users');
    }
}
