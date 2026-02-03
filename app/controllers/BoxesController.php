<?php

declare(strict_types=1);

class BoxesController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $boxes = (new BoxModel($this->db))->all();
        $this->render('boxes/index', [
            'title' => 'Box clínicos',
            'pageTitle' => 'Box clínicos',
            'boxes' => $boxes,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('boxes/form', [
            'title' => 'Nuevo box',
            'pageTitle' => 'Nuevo box',
            'box' => null,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'activo';
        if ($name === '') {
            flash('error', 'El nombre es obligatorio.');
            $this->redirect('/box/nuevo');
        }

        $this->db->execute(
            'INSERT INTO boxes (name, description, status, created_at, updated_at) VALUES (:name, :description, :status, NOW(), NOW())',
            [
                'name' => $name,
                'description' => $description,
                'status' => $status,
            ]
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'boxes', (int)$this->db->lastInsertId());
        flash('success', 'Box creado.');
        $this->redirect('/box');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $box = $this->db->fetch('SELECT * FROM boxes WHERE id = :id', ['id' => $id]);
        if (!$box) {
            $this->redirect('/box');
        }
        $this->render('boxes/form', [
            'title' => 'Editar box',
            'pageTitle' => 'Editar box',
            'box' => $box,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'activo';

        $this->db->execute(
            'UPDATE boxes SET name = :name, description = :description, status = :status, updated_at = NOW() WHERE id = :id',
            [
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'id' => $id,
            ]
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'update', 'boxes', $id);
        flash('success', 'Box actualizado.');
        $this->redirect('/box');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('DELETE FROM boxes WHERE id = :id', ['id' => $id]);
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'delete', 'boxes', $id);
        flash('success', 'Box eliminado.');
        $this->redirect('/box');
    }
}
