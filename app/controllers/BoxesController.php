<?php

class BoxesController extends Controller
{
    private BoxesModel $boxes;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->boxes = new BoxesModel($db);
    }

    private function requireCompany(): int
    {
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        return (int)$companyId;
    }

    public function index(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $boxes = $this->boxes->active($companyId);
        $this->render('boxes/index', [
            'title' => 'Box y salas',
            'subtitle' => 'Clínica',
            'boxes' => $boxes,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->requireCompany();
        $this->render('boxes/create', [
            'title' => 'Nuevo box',
            'subtitle' => 'Box y salas',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            flash('error', 'El nombre del box es obligatorio.');
            $this->redirect('index.php?route=boxes/create');
        }
        $existing = $this->boxes->findByName($companyId, $name);
        if ($existing) {
            flash('error', 'Este box ya existe. Puedes editarlo desde el listado.');
            $this->redirect('index.php?route=boxes/edit&id=' . $existing['id']);
        }
        $this->boxes->create([
            'company_id' => $companyId,
            'name' => $name,
            'capacity' => trim($_POST['capacity'] ?? ''),
            'equipment' => trim($_POST['equipment'] ?? ''),
            'status' => trim($_POST['status'] ?? 'Disponible'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'boxes');
        flash('success', 'Box creado correctamente.');
        $this->redirect('index.php?route=boxes');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $boxId = (int)($_GET['id'] ?? 0);
        $box = $this->boxes->findForCompany($boxId, $companyId);
        if (!$box) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=boxes');
        }
        $this->render('boxes/edit', [
            'title' => 'Editar box',
            'subtitle' => 'Box y salas',
            'boxId' => $boxId,
            'box' => $box,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $boxId = (int)($_GET['id'] ?? 0);
        $box = $this->boxes->findForCompany($boxId, $companyId);
        if (!$box) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=boxes');
        }
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            flash('error', 'El nombre del box es obligatorio.');
            $this->redirect('index.php?route=boxes/edit&id=' . $boxId);
        }
        $existing = $this->boxes->findByName($companyId, $name);
        if ($existing && (int)$existing['id'] !== $boxId) {
            flash('error', 'Ya existe otro box con ese nombre.');
            $this->redirect('index.php?route=boxes/edit&id=' . $boxId);
        }
        $this->boxes->update($boxId, [
            'name' => $name,
            'capacity' => trim($_POST['capacity'] ?? ''),
            'equipment' => trim($_POST['equipment'] ?? ''),
            'status' => trim($_POST['status'] ?? 'Disponible'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'boxes', $boxId);
        flash('success', 'Box actualizado correctamente.');
        $this->redirect('index.php?route=boxes');
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $boxId = (int)($_GET['id'] ?? 0);
        $box = $this->boxes->findForCompany($boxId, $companyId);
        if (!$box) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=boxes');
        }
        $this->render('boxes/show', [
            'title' => 'Detalle del box',
            'subtitle' => 'Box y salas',
            'boxId' => $boxId,
            'box' => $box,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $boxId = (int)($_POST['id'] ?? 0);
        $box = $this->boxes->findForCompany($boxId, $companyId);
        if (!$box) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=boxes');
        }
        $this->boxes->markDeleted($boxId, $companyId);
        audit($this->db, Auth::user()['id'], 'delete', 'boxes', $boxId);
        flash('success', 'Box eliminado correctamente.');
        $this->redirect('index.php?route=boxes');
    }
}
