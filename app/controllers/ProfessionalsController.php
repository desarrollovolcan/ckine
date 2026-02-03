<?php

class ProfessionalsController extends Controller
{
    private ProfessionalsModel $professionals;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->professionals = new ProfessionalsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $professionals = $this->professionals->active($companyId);
        $this->render('professionals/index', [
            'title' => 'Profesionales',
            'subtitle' => 'Clínica',
            'professionals' => $professionals,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('professionals/create', [
            'title' => 'Nuevo profesional',
            'subtitle' => 'Profesionales',
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
            flash('error', 'El nombre es obligatorio.');
            $this->redirect('index.php?route=professionals/create');
        }
        $email = trim($_POST['email'] ?? '');
        if ($email !== '' && !Validator::email($email)) {
            flash('error', 'El correo no es válido.');
            $this->redirect('index.php?route=professionals/create');
        }
        $data = [
            'company_id' => $companyId,
            'name' => $name,
            'specialty' => trim($_POST['specialty'] ?? '') ?: null,
            'email' => $email !== '' ? $email : null,
            'phone' => trim($_POST['phone'] ?? '') ?: null,
            'status' => $_POST['status'] ?? 'Activo',
            'notes' => trim($_POST['notes'] ?? '') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $professionalId = $this->professionals->create($data);
        audit($this->db, Auth::user()['id'], 'create', 'professionals', $professionalId);
        flash('success', 'Profesional creado correctamente.');
        $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $professionalId = (int)($_GET['id'] ?? 0);
        $professional = $companyId ? $this->professionals->findByCompany($companyId, $professionalId) : null;
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=professionals');
        }
        $this->render('professionals/edit', [
            'title' => 'Editar profesional',
            'subtitle' => 'Profesionales',
            'professional' => $professional,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = current_company_id();
        $professionalId = (int)($_POST['id'] ?? 0);
        $professional = $companyId ? $this->professionals->findByCompany($companyId, $professionalId) : null;
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=professionals');
        }
        $name = trim($_POST['name'] ?? '');
        if (!Validator::required($name)) {
            flash('error', 'El nombre es obligatorio.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        $email = trim($_POST['email'] ?? '');
        if ($email !== '' && !Validator::email($email)) {
            flash('error', 'El correo no es válido.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        $this->professionals->update($professionalId, [
            'name' => $name,
            'specialty' => trim($_POST['specialty'] ?? '') ?: null,
            'email' => $email !== '' ? $email : null,
            'phone' => trim($_POST['phone'] ?? '') ?: null,
            'status' => $_POST['status'] ?? 'Activo',
            'notes' => trim($_POST['notes'] ?? '') ?: null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'professionals', $professionalId);
        flash('success', 'Profesional actualizado correctamente.');
        $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $professionalId = (int)($_GET['id'] ?? 0);
        $professional = $companyId ? $this->professionals->findByCompany($companyId, $professionalId) : null;
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=professionals');
        }
        $this->render('professionals/show', [
            'title' => 'Perfil profesional',
            'subtitle' => 'Profesionales',
            'professional' => $professional,
        ]);
    }
}
