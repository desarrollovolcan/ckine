<?php

declare(strict_types=1);

class UsersController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $users = $this->db->fetchAll('SELECT u.*, r.name AS role_name FROM users u LEFT JOIN roles r ON r.id = u.role_id WHERE u.deleted_at IS NULL ORDER BY u.id DESC');
        $this->render('users/index', [
            'title' => 'Usuarios',
            'pageTitle' => 'Usuarios',
            'users' => $users,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $roles = (new RoleModel($this->db))->all();
        $this->render('users/form', [
            'title' => 'Nuevo usuario',
            'pageTitle' => 'Nuevo usuario',
            'roles' => $roles,
            'user' => null,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $roleId = (int)($_POST['role_id'] ?? 0);

        if ($name === '' || !Validator::email($email) || strlen($password) < 8) {
            flash('error', 'Completa los campos obligatorios con datos válidos.');
            $this->redirect('/usuarios/nuevo');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->db->execute('INSERT INTO users (name, email, password_hash, role_id, must_change_password, created_at, updated_at) VALUES (:name, :email, :password_hash, :role_id, 0, NOW(), NOW())', [
            'name' => $name,
            'email' => $email,
            'password_hash' => $hash,
            'role_id' => $roleId ?: null,
        ]);

        flash('success', 'Usuario creado.');
        $this->redirect('/usuarios');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->db->fetch('SELECT * FROM users WHERE id = :id', ['id' => $id]);
        if (!$user) {
            $this->redirect('/usuarios');
        }
        $roles = (new RoleModel($this->db))->all();
        $this->render('users/form', [
            'title' => 'Editar usuario',
            'pageTitle' => 'Editar usuario',
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $roleId = (int)($_POST['role_id'] ?? 0);

        if ($name === '' || !Validator::email($email)) {
            flash('error', 'Nombre y email son obligatorios.');
            $this->redirect('/usuarios/editar?id=' . $id);
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'role_id' => $roleId ?: null,
        ];
        $password = (string)($_POST['password'] ?? '');
        if ($password !== '') {
            if (strlen($password) < 8) {
                flash('error', 'La contraseña debe tener al menos 8 caracteres.');
                $this->redirect('/usuarios/editar?id=' . $id);
            }
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->execute('UPDATE users SET name = :name, email = :email, role_id = :role_id, password_hash = COALESCE(:password_hash, password_hash), updated_at = NOW() WHERE id = :id', [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password_hash' => $data['password_hash'] ?? null,
            'id' => $id,
        ]);

        flash('success', 'Usuario actualizado.');
        $this->redirect('/usuarios');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('UPDATE users SET deleted_at = NOW() WHERE id = :id', ['id' => $id]);
        flash('success', 'Usuario eliminado.');
        $this->redirect('/usuarios');
    }
}
