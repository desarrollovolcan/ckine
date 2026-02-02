<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\AuditLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class RolesController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('roles.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $roles = (new Role())->all();
        $this->view('roles/index', ['title' => 'Roles', 'roles' => $roles]);
    }

    public function create(): void
    {
        $this->authorize();
        $permissions = (new Permission())->all();
        $this->view('roles/create', ['title' => 'Nuevo rol', 'permissions' => $permissions]);
    }

    public function store(): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $name = Request::sanitize((string) Request::input('name'));
        $description = Request::sanitize((string) Request::input('description'));
        $validator->required('name', $name, 'Nombre requerido.');
        if ($validator->fails()) {
            $permissions = (new Permission())->all();
            $this->view('roles/create', ['title' => 'Nuevo rol', 'permissions' => $permissions, 'errors' => $validator->errors()]);
            return;
        }
        $roleId = (new Role())->create(['name' => $name, 'description' => $description]);
        (new RolePermission())->sync($roleId, (array) ($_POST['permissions'] ?? []));
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'roles', $roleId, ['name' => $name]);
        $this->redirect('/roles');
    }

    public function edit(string $id): void
    {
        $this->authorize();
        $role = (new Role())->find((int) $id);
        $permissions = (new Permission())->all();
        $selected = (new RolePermission())->getPermissionsForRole((int) $id);
        $this->view('roles/edit', ['title' => 'Editar rol', 'role' => $role, 'permissions' => $permissions, 'selected' => $selected]);
    }

    public function update(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $name = Request::sanitize((string) Request::input('name'));
        $description = Request::sanitize((string) Request::input('description'));
        $validator->required('name', $name, 'Nombre requerido.');
        if ($validator->fails()) {
            $permissions = (new Permission())->all();
            $selected = (new RolePermission())->getPermissionsForRole((int) $id);
            $this->view('roles/edit', ['title' => 'Editar rol', 'role' => (new Role())->find((int) $id), 'permissions' => $permissions, 'selected' => $selected, 'errors' => $validator->errors()]);
            return;
        }
        (new Role())->update((int) $id, ['name' => $name, 'description' => $description]);
        (new RolePermission())->sync((int) $id, (array) ($_POST['permissions'] ?? []));
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'update', 'roles', (int) $id, ['name' => $name]);
        $this->redirect('/roles');
    }

    public function delete(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/roles');
            return;
        }
        (new Role())->delete((int) $id);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'delete', 'roles', (int) $id, []);
        $this->redirect('/roles');
    }
}
