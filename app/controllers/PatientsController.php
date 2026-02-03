<?php

class PatientsController extends Controller
{
    private PatientsModel $patients;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->patients = new PatientsModel($db);
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
        $this->requireCompany();
        $this->render('patients/create', [
            'title' => 'Nuevo paciente',
            'subtitle' => 'Pacientes',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            flash('error', 'El nombre es obligatorio.');
            $this->redirect('index.php?route=patients/create');
        }
        $birthdate = trim($_POST['birthdate'] ?? '');
        $birthdate = $birthdate !== '' ? $birthdate : null;
        $this->patients->create([
            'company_id' => $companyId,
            'name' => $name,
            'rut' => trim($_POST['rut'] ?? ''),
            'birthdate' => $birthdate,
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'status' => trim($_POST['status'] ?? 'Nuevo'),
            'notes' => trim($_POST['notes'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'patients');
        flash('success', 'Paciente creado correctamente.');
        $this->redirect('index.php?route=patients');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $patientId = (int)($_GET['id'] ?? 0);
        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $this->render('patients/edit', [
            'title' => 'Editar paciente',
            'subtitle' => 'Pacientes',
            'patientId' => $patientId,
            'patient' => $patient,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $patientId = (int)($_GET['id'] ?? 0);
        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            flash('error', 'El nombre es obligatorio.');
            $this->redirect('index.php?route=patients/edit&id=' . $patientId);
        }
        $birthdate = trim($_POST['birthdate'] ?? '');
        $birthdate = $birthdate !== '' ? $birthdate : null;
        $this->patients->update($patientId, [
            'name' => $name,
            'rut' => trim($_POST['rut'] ?? ''),
            'birthdate' => $birthdate,
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'status' => trim($_POST['status'] ?? 'Activo'),
            'notes' => trim($_POST['notes'] ?? ''),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'update', 'patients', $patientId);
        flash('success', 'Paciente actualizado correctamente.');
        $this->redirect('index.php?route=patients');
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $patientId = (int)($_GET['id'] ?? 0);
        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $this->render('patients/show', [
            'title' => 'Ficha del paciente',
            'subtitle' => 'Pacientes',
            'patientId' => $patientId,
            'patient' => $patient,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $patientId = (int)($_POST['id'] ?? 0);
        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $this->patients->markDeleted($patientId, $companyId);
        audit($this->db, Auth::user()['id'], 'delete', 'patients', $patientId);
        flash('success', 'Paciente eliminado correctamente.');
        $this->redirect('index.php?route=patients');
    }
}
