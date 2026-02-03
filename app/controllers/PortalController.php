<?php

declare(strict_types=1);

class PortalController extends BaseController
{
    public function index(): void
    {
        $settings = $this->db->fetch('SELECT * FROM portal_settings ORDER BY id DESC LIMIT 1');
        $enabled = $settings ? (bool)$settings['is_enabled'] : ($this->config['portal_enabled'] ?? true);

        if (!$enabled) {
            $this->renderPublic('portal/disabled', [
                'title' => 'Agendamiento',
                'pageTitle' => 'Agendamiento',
            ]);
            return;
        }

        $services = (new ServiceModel($this->db))->allActive();
        $professionals = (new ProfessionalModel($this->db))->allActive();
        $boxes = (new BoxModel($this->db))->allActive();
        $this->renderPublic('portal/index', [
            'title' => 'Agendar sesión',
            'pageTitle' => 'Agendar sesión',
            'services' => $services,
            'professionals' => $professionals,
            'boxes' => $boxes,
        ]);
    }

    public function store(): void
    {
        verify_csrf();

        $rut = normalize_rut($_POST['rut'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');

        if ($firstName === '' || $lastName === '') {
            flash('error', 'Nombre y apellido son obligatorios.');
            $this->redirect('/portal');
        }
        if ($rut !== '' && !is_valid_rut($rut)) {
            flash('error', 'RUT inválido.');
            $this->redirect('/portal');
        }

        $patient = null;
        if ($rut !== '') {
            $patient = $this->db->fetch('SELECT * FROM patients WHERE rut = :rut AND deleted_at IS NULL', ['rut' => $rut]);
        }
        if (!$patient && $email !== '') {
            $patient = $this->db->fetch('SELECT * FROM patients WHERE email = :email AND deleted_at IS NULL', ['email' => $email]);
        }
        if (!$patient) {
            $this->db->execute(
                'INSERT INTO patients (first_name, last_name, rut, email, phone, created_at, updated_at)
                 VALUES (:first_name, :last_name, :rut, :email, :phone, NOW(), NOW())',
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'rut' => $rut,
                    'email' => $email,
                    'phone' => trim($_POST['phone'] ?? ''),
                ]
            );
            $patientId = (int)$this->db->lastInsertId();
        } else {
            $patientId = (int)$patient['id'];
        }

        $date = $_POST['date'] ?? '';
        $time = $_POST['start_time'] ?? '';
        $duration = (int)($_POST['duration_minutes'] ?? 60);
        $startAt = trim($date . ' ' . $time);
        $endAt = date('Y-m-d H:i:s', strtotime($startAt . " +{$duration} minutes"));

        $model = new AppointmentModel($this->db);
        $professionalId = (int)($_POST['professional_id'] ?? 0);
        $boxId = (int)($_POST['box_id'] ?? 0);
        if ($model->hasConflict($professionalId, $boxId, $startAt, $endAt)) {
            flash('error', 'El horario seleccionado no está disponible.');
            $this->redirect('/portal');
        }

        $this->db->execute(
            'INSERT INTO appointments (patient_id, professional_id, box_id, service_id, start_at, end_at, status, notes, created_at, updated_at)
             VALUES (:patient_id, :professional_id, :box_id, :service_id, :start_at, :end_at, "pendiente", :notes, NOW(), NOW())',
            [
                'patient_id' => $patientId,
                'professional_id' => $professionalId,
                'box_id' => $boxId,
                'service_id' => (int)($_POST['service_id'] ?? 0),
                'start_at' => $startAt,
                'end_at' => $endAt,
                'notes' => trim($_POST['notes'] ?? ''),
            ]
        );

        flash('success', 'Solicitud de cita enviada. Te contactaremos para confirmar.');
        $this->redirect('/portal');
    }
}
