<?php

class ProfessionalsController extends Controller
{
    private ProfessionalsModel $professionals;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->professionals = new ProfessionalsModel($db);
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
        $this->requireCompany();
        $this->render('professionals/create', [
            'title' => 'Nuevo profesional',
            'subtitle' => 'Profesionales',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $name = trim($_POST['name'] ?? '');
        $rut = normalize_rut($_POST['rut'] ?? '');
        $specialty = trim($_POST['specialty'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $licenseNumber = trim($_POST['license_number'] ?? '');
        $schedule = trim($_POST['schedule'] ?? '');
        $modality = trim($_POST['modality'] ?? '');
        $status = trim($_POST['status'] ?? 'Activo');
        $allowedModalities = ['Presencial', 'Mixta', 'Telemedicina'];
        $allowedStatuses = ['Activo', 'En pausa'];

        if (!Validator::required($name) || !Validator::required($rut) || !Validator::required($specialty) || !Validator::required($email)) {
            flash('error', 'Completa los campos obligatorios para registrar al profesional.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!Validator::rut($rut)) {
            flash('error', 'El RUT ingresado no es válido.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!Validator::email($email)) {
            flash('error', 'El correo ingresado no es válido.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!Validator::required($phone) || !Validator::required($licenseNumber) || !Validator::required($schedule) || !Validator::required($modality)) {
            flash('error', 'Completa teléfono, registro profesional, modalidad y horario.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!in_array($modality, $allowedModalities, true)) {
            flash('error', 'Selecciona una modalidad válida.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!in_array($status, $allowedStatuses, true)) {
            flash('error', 'Selecciona un estado válido.');
            $this->redirect('index.php?route=professionals/create');
        }
        $this->professionals->create([
            'company_id' => $companyId,
            'name' => $name,
            'rut' => $rut,
            'license_number' => $licenseNumber,
            'specialty' => $specialty,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
            'modality' => $modality,
            'box' => trim($_POST['box'] ?? ''),
            'schedule' => $schedule,
            'notes' => trim($_POST['notes'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'professionals');
        flash('success', 'Profesional creado correctamente.');
        $this->redirect('index.php?route=professionals');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $professionalId = (int)($_GET['id'] ?? 0);
        $professional = $this->professionals->findForCompany($professionalId, $companyId);
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=professionals');
        }
        $this->render('professionals/edit', [
            'title' => 'Editar profesional',
            'subtitle' => 'Profesionales',
            'professionalId' => $professionalId,
            'professional' => $professional,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $professionalId = (int)($_GET['id'] ?? 0);
        $professional = $this->professionals->findForCompany($professionalId, $companyId);
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=professionals');
        }
        $name = trim($_POST['name'] ?? '');
        $rut = normalize_rut($_POST['rut'] ?? '');
        $specialty = trim($_POST['specialty'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $licenseNumber = trim($_POST['license_number'] ?? '');
        $schedule = trim($_POST['schedule'] ?? '');
        $modality = trim($_POST['modality'] ?? '');
        $status = trim($_POST['status'] ?? 'Activo');
        $allowedModalities = ['Presencial', 'Mixta', 'Telemedicina'];
        $allowedStatuses = ['Activo', 'En pausa'];

        if (!Validator::required($name) || !Validator::required($rut) || !Validator::required($specialty) || !Validator::required($email)) {
            flash('error', 'Completa los campos obligatorios para actualizar al profesional.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!Validator::rut($rut)) {
            flash('error', 'El RUT ingresado no es válido.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!Validator::email($email)) {
            flash('error', 'El correo ingresado no es válido.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!Validator::required($phone) || !Validator::required($licenseNumber) || !Validator::required($schedule) || !Validator::required($modality)) {
            flash('error', 'Completa teléfono, registro profesional, modalidad y horario.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!in_array($modality, $allowedModalities, true)) {
            flash('error', 'Selecciona una modalidad válida.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!in_array($status, $allowedStatuses, true)) {
            flash('error', 'Selecciona un estado válido.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        $this->professionals->update($professionalId, [
            'name' => $name,
            'rut' => $rut,
            'license_number' => $licenseNumber,
            'specialty' => $specialty,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
            'modality' => $modality,
            'box' => trim($_POST['box'] ?? ''),
            'schedule' => $schedule,
            'notes' => trim($_POST['notes'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'professionals', $professionalId);
        flash('success', 'Profesional actualizado correctamente.');
        $this->redirect('index.php?route=professionals');
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $professionalId = (int)($_GET['id'] ?? 0);
        $professional = $this->professionals->findForCompany($professionalId, $companyId);
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=professionals');
        }
        $this->render('professionals/show', [
            'title' => 'Perfil profesional',
            'subtitle' => 'Profesionales',
            'professionalId' => $professionalId,
            'professional' => $professional,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $professionalId = (int)($_POST['id'] ?? 0);
        $professional = $this->professionals->findForCompany($professionalId, $companyId);
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=professionals');
        }
        $this->professionals->markDeleted($professionalId, $companyId);
        audit($this->db, Auth::user()['id'], 'delete', 'professionals', $professionalId);
        flash('success', 'Profesional eliminado correctamente.');
        $this->redirect('index.php?route=professionals');
    }
}
