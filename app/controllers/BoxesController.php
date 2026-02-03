<?php

class BoxesController extends Controller
{
    private BoxesModel $boxes;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->boxes = new BoxesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
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
        $this->render('boxes/create', [
            'title' => 'Nuevo box',
            'subtitle' => 'Box y salas',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $name = trim($_POST['name'] ?? '');
        if (!Validator::required($name)) {
            flash('error', 'El nombre del box es obligatorio.');
            $this->redirect('index.php?route=boxes/create');
        }
        $data = [
            'company_id' => $companyId,
            'name' => $name,
            'capacity' => trim($_POST['capacity'] ?? '') ?: null,
            'equipment' => trim($_POST['equipment'] ?? '') ?: null,
            'status' => $_POST['status'] ?? 'Disponible',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $boxId = $this->boxes->create($data);
        audit($this->db, Auth::user()['id'], 'create', 'boxes', $boxId);
        flash('success', 'Box creado correctamente.');
        $this->redirect('index.php?route=boxes/edit&id=' . $boxId);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $boxId = (int)($_GET['id'] ?? 0);
        $box = $companyId ? $this->boxes->findByCompany($companyId, $boxId) : null;
        if (!$box) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=boxes');
        }
        $this->render('boxes/edit', [
            'title' => 'Editar box',
            'subtitle' => 'Box y salas',
            'box' => $box,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = current_company_id();
        $boxId = (int)($_POST['id'] ?? 0);
        $box = $companyId ? $this->boxes->findByCompany($companyId, $boxId) : null;
        if (!$box) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=boxes');
        }
        $name = trim($_POST['name'] ?? '');
        if (!Validator::required($name)) {
            flash('error', 'El nombre del box es obligatorio.');
            $this->redirect('index.php?route=boxes/edit&id=' . $boxId);
        }
        $this->boxes->update($boxId, [
            'name' => $name,
            'capacity' => trim($_POST['capacity'] ?? '') ?: null,
            'equipment' => trim($_POST['equipment'] ?? '') ?: null,
            'status' => $_POST['status'] ?? 'Disponible',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'boxes', $boxId);
        flash('success', 'Box actualizado correctamente.');
        $this->redirect('index.php?route=boxes/edit&id=' . $boxId);
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $boxId = (int)($_GET['id'] ?? 0);
        $box = $companyId ? $this->boxes->findByCompany($companyId, $boxId) : null;
        if (!$box) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=boxes');
        }
        $this->render('boxes/show', [
            'title' => 'Detalle del box',
            'subtitle' => 'Box y salas',
            'box' => $box,
        ]);
    }
}
