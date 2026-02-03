<?php

declare(strict_types=1);

class RolesController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $roles = (new RoleModel($this->db))->all();
        $this->render('roles/index', [
            'title' => 'Roles',
            'pageTitle' => 'Roles',
            'roles' => $roles,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $permissions = (new PermissionModel($this->db))->allOrdered();
        $this->render('roles/form', [
            'title' => 'Nuevo rol',
            'pageTitle' => 'Nuevo rol',
            'role' => null,
            'permissions' => $permissions,
            'selected' => [],
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($name === '') {
            flash('error', 'El nombre es obligatorio.');
            $this->redirect('/roles/nuevo');
        }

        $this->db->execute('INSERT INTO roles (name, description, created_at, updated_at) VALUES (:name, :description, NOW(), NOW())', [
            'name' => $name,
            'description' => $description,
        ]);
        $roleId = (int)$this->db->lastInsertId();
        $permissions = $_POST['permissions'] ?? [];
        foreach ($permissions as $permissionId) {
            $this->db->execute('INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)', [
                'role_id' => $roleId,
                'permission_id' => (int)$permissionId,
            ]);
        }

        flash('success', 'Rol creado.');
        $this->redirect('/roles');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $role = $this->db->fetch('SELECT * FROM roles WHERE id = :id', ['id' => $id]);
        if (!$role) {
            $this->redirect('/roles');
        }
        $permissions = (new PermissionModel($this->db))->allOrdered();
        $selectedRows = $this->db->fetchAll('SELECT permission_id FROM role_permissions WHERE role_id = :role_id', ['role_id' => $id]);
        $selected = array_map(static fn ($row) => (int)$row['permission_id'], $selectedRows);
        $this->render('roles/form', [
            'title' => 'Editar rol',
            'pageTitle' => 'Editar rol',
            'role' => $role,
            'permissions' => $permissions,
            'selected' => $selected,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($name === '') {
            flash('error', 'El nombre es obligatorio.');
            $this->redirect('/roles/editar?id=' . $id);
        }

        $this->db->execute('UPDATE roles SET name = :name, description = :description, updated_at = NOW() WHERE id = :id', [
            'name' => $name,
            'description' => $description,
            'id' => $id,
        ]);

        $this->db->execute('DELETE FROM role_permissions WHERE role_id = :role_id', ['role_id' => $id]);
        $permissions = $_POST['permissions'] ?? [];
        foreach ($permissions as $permissionId) {
            $this->db->execute('INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)', [
                'role_id' => $id,
                'permission_id' => (int)$permissionId,
            ]);
        }

        flash('success', 'Rol actualizado.');
        $this->redirect('/roles');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('DELETE FROM roles WHERE id = :id', ['id' => $id]);
        flash('success', 'Rol eliminado.');
        $this->redirect('/roles');
    }
}
