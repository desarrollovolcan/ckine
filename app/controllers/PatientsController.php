<?php

declare(strict_types=1);

class PatientsController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $patients = (new PatientModel($this->db))->allActive();
        $this->render('patients/index', [
            'title' => 'Pacientes',
            'pageTitle' => 'Pacientes',
            'patients' => $patients,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('patients/form', [
            'title' => 'Nuevo paciente',
            'pageTitle' => 'Nuevo paciente',
            'patient' => null,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();

        $payload = $this->payload();
        $errors = $this->validate($payload);
        if ($errors) {
            flash('error', implode(' ', $errors));
            $this->redirect('/pacientes/nuevo');
        }

        $this->db->execute(
            'INSERT INTO patients (first_name, last_name, rut, birth_date, phone, email, address, insurance, emergency_contact_name, emergency_contact_phone, notes, created_at, updated_at)
            VALUES (:first_name, :last_name, :rut, :birth_date, :phone, :email, :address, :insurance, :emergency_contact_name, :emergency_contact_phone, :notes, NOW(), NOW())',
            $payload
        );

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'patients', (int)$this->db->lastInsertId(), $payload);
        flash('success', 'Paciente creado.');
        $this->redirect('/pacientes');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $patient = $this->db->fetch('SELECT * FROM patients WHERE id = :id', ['id' => $id]);
        if (!$patient) {
            $this->redirect('/pacientes');
        }
        $this->render('patients/form', [
            'title' => 'Editar paciente',
            'pageTitle' => 'Editar paciente',
            'patient' => $patient,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $payload = $this->payload();
        $errors = $this->validate($payload);
        if ($errors) {
            flash('error', implode(' ', $errors));
            $this->redirect('/pacientes/editar?id=' . $id);
        }

        $payload['id'] = $id;
        $this->db->execute(
            'UPDATE patients SET first_name = :first_name, last_name = :last_name, rut = :rut, birth_date = :birth_date, phone = :phone, email = :email, address = :address, insurance = :insurance,
            emergency_contact_name = :emergency_contact_name, emergency_contact_phone = :emergency_contact_phone, notes = :notes, updated_at = NOW() WHERE id = :id',
            $payload
        );

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'update', 'patients', $id, $payload);
        flash('success', 'Paciente actualizado.');
        $this->redirect('/pacientes');
    }

    public function show(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $patient = $this->db->fetch('SELECT * FROM patients WHERE id = :id', ['id' => $id]);
        if (!$patient) {
            $this->redirect('/pacientes');
        }
        $this->render('patients/show', [
            'title' => 'Ficha paciente',
            'pageTitle' => 'Ficha paciente',
            'patient' => $patient,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('UPDATE patients SET deleted_at = NOW() WHERE id = :id', ['id' => $id]);
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'delete', 'patients', $id);
        flash('success', 'Paciente eliminado.');
        $this->redirect('/pacientes');
    }

    private function payload(): array
    {
        return [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'rut' => normalize_rut($_POST['rut'] ?? ''),
            'birth_date' => $_POST['birth_date'] ?? null,
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'insurance' => trim($_POST['insurance'] ?? ''),
            'emergency_contact_name' => trim($_POST['emergency_contact_name'] ?? ''),
            'emergency_contact_phone' => trim($_POST['emergency_contact_phone'] ?? ''),
            'notes' => trim($_POST['notes'] ?? ''),
        ];
    }

    private function validate(array $payload): array
    {
        $errors = [];
        if ($payload['first_name'] === '' || $payload['last_name'] === '') {
            $errors[] = 'Nombre y apellido son obligatorios.';
        }
        if ($payload['rut'] !== '' && !is_valid_rut($payload['rut'])) {
            $errors[] = 'RUT inválido.';
        }
        if ($payload['email'] !== '' && !Validator::email($payload['email'])) {
            $errors[] = 'Email inválido.';
        }
        return $errors;
    }
}
