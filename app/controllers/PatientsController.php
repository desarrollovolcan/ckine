<?php

class PatientsController extends Controller
{
    private PatientsModel $patients;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->patients = new PatientsModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $patients = $this->patients->active($companyId);
        $this->render('patients/index', [
            'title' => 'Pacientes',
            'subtitle' => 'Clínica',
            'patients' => $patients,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('patients/create', [
            'title' => 'Nuevo paciente',
            'subtitle' => 'Pacientes',
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
            flash('error', 'El nombre del paciente es obligatorio.');
            $this->redirect('index.php?route=patients/create');
        }
        $rut = normalize_rut($_POST['rut'] ?? '');
        if ($rut !== '' && !is_valid_rut($rut)) {
            flash('error', 'El RUT ingresado no es válido.');
            $this->redirect('index.php?route=patients/create');
        }
        $email = trim($_POST['email'] ?? '');
        if ($email !== '' && !Validator::email($email)) {
            flash('error', 'El correo no es válido.');
            $this->redirect('index.php?route=patients/create');
        }
        $data = [
            'company_id' => $companyId,
            'name' => $name,
            'rut' => $rut,
            'birthdate' => $_POST['birthdate'] ?? null,
            'email' => $email !== '' ? $email : null,
            'phone' => trim($_POST['phone'] ?? '') ?: null,
            'status' => $_POST['status'] ?? 'Activo',
            'notes' => trim($_POST['notes'] ?? '') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $patientId = $this->patients->create($data);
        audit($this->db, Auth::user()['id'], 'create', 'patients', $patientId);
        flash('success', 'Paciente creado correctamente.');
        $this->redirect('index.php?route=patients/edit&id=' . $patientId);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $patientId = (int)($_GET['id'] ?? 0);
        $patient = $companyId ? $this->patients->findByCompany($companyId, $patientId) : null;
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $this->render('patients/edit', [
            'title' => 'Editar paciente',
            'subtitle' => 'Pacientes',
            'patient' => $patient,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = current_company_id();
        $patientId = (int)($_POST['id'] ?? 0);
        $patient = $companyId ? $this->patients->findByCompany($companyId, $patientId) : null;
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $name = trim($_POST['name'] ?? '');
        if (!Validator::required($name)) {
            flash('error', 'El nombre del paciente es obligatorio.');
            $this->redirect('index.php?route=patients/edit&id=' . $patientId);
        }
        $rut = normalize_rut($_POST['rut'] ?? '');
        if ($rut !== '' && !is_valid_rut($rut)) {
            flash('error', 'El RUT ingresado no es válido.');
            $this->redirect('index.php?route=patients/edit&id=' . $patientId);
        }
        $email = trim($_POST['email'] ?? '');
        if ($email !== '' && !Validator::email($email)) {
            flash('error', 'El correo no es válido.');
            $this->redirect('index.php?route=patients/edit&id=' . $patientId);
        }
        $this->patients->update($patientId, [
            'name' => $name,
            'rut' => $rut,
            'birthdate' => $_POST['birthdate'] ?? null,
            'email' => $email !== '' ? $email : null,
            'phone' => trim($_POST['phone'] ?? '') ?: null,
            'status' => $_POST['status'] ?? 'Activo',
            'notes' => trim($_POST['notes'] ?? '') ?: null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'patients', $patientId);
        flash('success', 'Paciente actualizado correctamente.');
        $this->redirect('index.php?route=patients/edit&id=' . $patientId);
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $patientId = (int)($_GET['id'] ?? 0);
        $patient = $companyId ? $this->patients->findByCompany($companyId, $patientId) : null;
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $this->render('patients/show', [
            'title' => 'Ficha del paciente',
            'subtitle' => 'Pacientes',
            'patient' => $patient,
        ]);
    }
}
