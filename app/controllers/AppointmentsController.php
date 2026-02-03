<?php

declare(strict_types=1);

class AppointmentsController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $filters = [
            'date' => $_GET['date'] ?? '',
            'status' => $_GET['status'] ?? '',
            'professional_id' => $_GET['professional_id'] ?? '',
            'box_id' => $_GET['box_id'] ?? '',
            'patient_id' => $_GET['patient_id'] ?? '',
        ];
        $model = new AppointmentModel($this->db);
        $appointments = $model->allWithRelations($filters);
        $patients = (new PatientModel($this->db))->allActive();
        $professionals = (new ProfessionalModel($this->db))->allActive();
        $boxes = (new BoxModel($this->db))->allActive();
        $this->render('appointments/index', [
            'title' => 'Agenda',
            'pageTitle' => 'Agenda',
            'appointments' => $appointments,
            'filters' => $filters,
            'patients' => $patients,
            'professionals' => $professionals,
            'boxes' => $boxes,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $patients = (new PatientModel($this->db))->allActive();
        $professionals = (new ProfessionalModel($this->db))->allActive();
        $boxes = (new BoxModel($this->db))->allActive();
        $services = (new ServiceModel($this->db))->allActive();
        $this->render('appointments/form', [
            'title' => 'Nueva cita',
            'pageTitle' => 'Nueva cita',
            'appointment' => null,
            'patients' => $patients,
            'professionals' => $professionals,
            'boxes' => $boxes,
            'services' => $services,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $payload = $this->payload();
        $model = new AppointmentModel($this->db);

        if ($model->hasConflict($payload['professional_id'], $payload['box_id'], $payload['start_at'], $payload['end_at'])) {
            flash('error', 'Existe un choque de horario con el profesional o el box.');
            $this->redirect('/agenda/nueva');
        }

        $this->db->execute(
            'INSERT INTO appointments (patient_id, professional_id, box_id, service_id, start_at, end_at, status, notes, created_at, updated_at)
             VALUES (:patient_id, :professional_id, :box_id, :service_id, :start_at, :end_at, :status, :notes, NOW(), NOW())',
            $payload
        );
        $appointmentId = (int)$this->db->lastInsertId();
        $this->logStatus($appointmentId, $payload['status'], 'Creación de cita');

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'appointments', $appointmentId, $payload);
        flash('success', 'Cita creada.');
        $this->redirect('/agenda');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $appointment = $this->db->fetch('SELECT * FROM appointments WHERE id = :id', ['id' => $id]);
        if (!$appointment) {
            $this->redirect('/agenda');
        }
        $patients = (new PatientModel($this->db))->allActive();
        $professionals = (new ProfessionalModel($this->db))->allActive();
        $boxes = (new BoxModel($this->db))->allActive();
        $services = (new ServiceModel($this->db))->allActive();
        $this->render('appointments/form', [
            'title' => 'Editar cita',
            'pageTitle' => 'Editar cita',
            'appointment' => $appointment,
            'patients' => $patients,
            'professionals' => $professionals,
            'boxes' => $boxes,
            'services' => $services,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $payload = $this->payload();
        $payload['id'] = $id;
        $model = new AppointmentModel($this->db);

        if ($model->hasConflict($payload['professional_id'], $payload['box_id'], $payload['start_at'], $payload['end_at'], $id)) {
            flash('error', 'Existe un choque de horario con el profesional o el box.');
            $this->redirect('/agenda/editar?id=' . $id);
        }

        $this->db->execute(
            'UPDATE appointments SET patient_id = :patient_id, professional_id = :professional_id, box_id = :box_id, service_id = :service_id, start_at = :start_at, end_at = :end_at, status = :status, notes = :notes, updated_at = NOW() WHERE id = :id',
            $payload
        );
        $this->logStatus($id, $payload['status'], 'Actualización de cita');

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'update', 'appointments', $id, $payload);
        flash('success', 'Cita actualizada.');
        $this->redirect('/agenda');
    }

    public function updateStatus(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'pendiente';
        $reason = trim($_POST['reason'] ?? '');

        $this->db->execute('UPDATE appointments SET status = :status, cancel_reason = :reason, updated_at = NOW() WHERE id = :id', [
            'status' => $status,
            'reason' => $reason,
            'id' => $id,
        ]);
        $this->logStatus($id, $status, $reason !== '' ? $reason : 'Actualización de estado');

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'status', 'appointments', $id, ['status' => $status, 'reason' => $reason]);
        flash('success', 'Estado actualizado.');
        $this->redirect('/agenda');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('DELETE FROM appointments WHERE id = :id', ['id' => $id]);
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'delete', 'appointments', $id);
        flash('success', 'Cita eliminada.');
        $this->redirect('/agenda');
    }

    private function payload(): array
    {
        $startDate = $_POST['date'] ?? '';
        $startTime = $_POST['start_time'] ?? '';
        $duration = (int)($_POST['duration_minutes'] ?? 0);
        $startAt = trim($startDate . ' ' . $startTime);
        $endAt = date('Y-m-d H:i:s', strtotime($startAt . " +{$duration} minutes"));

        return [
            'patient_id' => (int)($_POST['patient_id'] ?? 0),
            'professional_id' => (int)($_POST['professional_id'] ?? 0),
            'box_id' => (int)($_POST['box_id'] ?? 0),
            'service_id' => (int)($_POST['service_id'] ?? 0),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'status' => $_POST['status'] ?? 'pendiente',
            'notes' => trim($_POST['notes'] ?? ''),
        ];
    }

    private function logStatus(int $appointmentId, string $status, string $note): void
    {
        $this->db->execute(
            'INSERT INTO appointment_status_logs (appointment_id, status, note, user_id, created_at) VALUES (:appointment_id, :status, :note, :user_id, NOW())',
            [
                'appointment_id' => $appointmentId,
                'status' => $status,
                'note' => $note,
                'user_id' => (int)(Auth::user()['id'] ?? 0),
            ]
        );
    }
}
