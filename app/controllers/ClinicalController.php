<?php

declare(strict_types=1);

class ClinicalController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $patients = (new PatientModel($this->db))->allActive();
        $this->render('clinical/index', [
            'title' => 'Fichas clínicas',
            'pageTitle' => 'Fichas clínicas',
            'patients' => $patients,
        ]);
    }

    public function show(): void
    {
        $this->requireLogin();
        $patientId = (int)($_GET['id'] ?? 0);
        $patient = $this->db->fetch('SELECT * FROM patients WHERE id = :id', ['id' => $patientId]);
        if (!$patient) {
            $this->redirect('/fichas');
        }
        $evaluation = (new ClinicalEvaluationModel($this->db))->latestByPatient($patientId);
        $evolutions = (new ClinicalEvolutionModel($this->db))->forPatient($patientId);
        $attachments = (new AttachmentModel($this->db))->forPatient($patientId);
        $appointments = $this->db->fetchAll('SELECT * FROM appointments WHERE patient_id = :patient_id ORDER BY start_at DESC', [
            'patient_id' => $patientId,
        ]);

        $this->render('clinical/show', [
            'title' => 'Ficha clínica',
            'pageTitle' => 'Ficha clínica',
            'patient' => $patient,
            'evaluation' => $evaluation,
            'evolutions' => $evolutions,
            'attachments' => $attachments,
            'appointments' => $appointments,
        ]);
    }

    public function storeEvaluation(): void
    {
        $this->requireLogin();
        verify_csrf();
        $patientId = (int)($_POST['patient_id'] ?? 0);

        $this->db->execute(
            'INSERT INTO patient_evaluations (patient_id, appointment_id, reason, history, diagnosis, objectives, plan, created_at, updated_at)
            VALUES (:patient_id, :appointment_id, :reason, :history, :diagnosis, :objectives, :plan, NOW(), NOW())',
            [
                'patient_id' => $patientId,
                'appointment_id' => ($_POST['appointment_id'] ?? '') !== '' ? (int)$_POST['appointment_id'] : null,
                'reason' => trim($_POST['reason'] ?? ''),
                'history' => trim($_POST['history'] ?? ''),
                'diagnosis' => trim($_POST['diagnosis'] ?? ''),
                'objectives' => trim($_POST['objectives'] ?? ''),
                'plan' => trim($_POST['plan'] ?? ''),
            ]
        );

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'patient_evaluations', (int)$this->db->lastInsertId(), ['patient_id' => $patientId]);
        flash('success', 'Evaluación registrada.');
        $this->redirect('/fichas/ver?id=' . $patientId);
    }

    public function storeEvolution(): void
    {
        $this->requireLogin();
        verify_csrf();
        $patientId = (int)($_POST['patient_id'] ?? 0);

        $this->db->execute(
            'INSERT INTO patient_evolutions (patient_id, appointment_id, notes, procedures, exercises, created_at)
            VALUES (:patient_id, :appointment_id, :notes, :procedures, :exercises, NOW())',
            [
                'patient_id' => $patientId,
                'appointment_id' => ($_POST['appointment_id'] ?? '') !== '' ? (int)$_POST['appointment_id'] : null,
                'notes' => trim($_POST['notes'] ?? ''),
                'procedures' => trim($_POST['procedures'] ?? ''),
                'exercises' => trim($_POST['exercises'] ?? ''),
            ]
        );

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'patient_evolutions', (int)$this->db->lastInsertId(), ['patient_id' => $patientId]);
        flash('success', 'Evolución registrada.');
        $this->redirect('/fichas/ver?id=' . $patientId);
    }

    public function storeAttachment(): void
    {
        $this->requireLogin();
        verify_csrf();
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $appointmentId = ($_POST['appointment_id'] ?? '') !== '' ? (int)$_POST['appointment_id'] : null;

        $result = store_attachment($_FILES['attachment'] ?? []);
        if ($result['error']) {
            flash('error', $result['error']);
            $this->redirect('/fichas/ver?id=' . $patientId);
        }

        $this->db->execute(
            'INSERT INTO attachments (patient_id, appointment_id, file_path, file_name, file_type, created_at)
             VALUES (:patient_id, :appointment_id, :file_path, :file_name, :file_type, NOW())',
            [
                'patient_id' => $patientId,
                'appointment_id' => $appointmentId,
                'file_path' => $result['path'],
                'file_name' => $_FILES['attachment']['name'] ?? 'archivo',
                'file_type' => $_FILES['attachment']['type'] ?? '',
            ]
        );

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'attachments', (int)$this->db->lastInsertId(), ['patient_id' => $patientId]);
        flash('success', 'Adjunto subido.');
        $this->redirect('/fichas/ver?id=' . $patientId);
    }
}
