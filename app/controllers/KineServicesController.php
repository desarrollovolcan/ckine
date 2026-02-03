<?php

declare(strict_types=1);

class KineServicesController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $services = (new ServiceModel($this->db))->all();
        $this->render('services/index', [
            'title' => 'Servicios',
            'pageTitle' => 'Servicios',
            'services' => $services,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('services/form', [
            'title' => 'Nuevo servicio',
            'pageTitle' => 'Nuevo servicio',
            'service' => null,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();

        $payload = $this->payload();
        if ($payload['name'] === '' || $payload['duration_minutes'] <= 0) {
            flash('error', 'Nombre y duración son obligatorios.');
            $this->redirect('/servicios/nuevo');
        }

        $this->db->execute(
            'INSERT INTO services (name, duration_minutes, price, description, active, created_at, updated_at)
            VALUES (:name, :duration_minutes, :price, :description, :active, NOW(), NOW())',
            $payload
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'services', (int)$this->db->lastInsertId());
        flash('success', 'Servicio creado.');
        $this->redirect('/servicios');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $service = $this->db->fetch('SELECT * FROM services WHERE id = :id', ['id' => $id]);
        if (!$service) {
            $this->redirect('/servicios');
        }
        $this->render('services/form', [
            'title' => 'Editar servicio',
            'pageTitle' => 'Editar servicio',
            'service' => $service,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $payload = $this->payload();
        $payload['id'] = $id;

        $this->db->execute(
            'UPDATE services SET name = :name, duration_minutes = :duration_minutes, price = :price, description = :description, active = :active, updated_at = NOW() WHERE id = :id',
            $payload
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'update', 'services', $id);
        flash('success', 'Servicio actualizado.');
        $this->redirect('/servicios');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('DELETE FROM services WHERE id = :id', ['id' => $id]);
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'delete', 'services', $id);
        flash('success', 'Servicio eliminado.');
        $this->redirect('/servicios');
    }

    private function payload(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'duration_minutes' => (int)($_POST['duration_minutes'] ?? 0),
            'price' => ($_POST['price'] ?? '') !== '' ? (float)$_POST['price'] : null,
            'description' => trim($_POST['description'] ?? ''),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];
    }
}
