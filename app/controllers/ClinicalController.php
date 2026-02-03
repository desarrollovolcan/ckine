<?php

class ClinicalController extends Controller
{
    private PatientsModel $patients;
    private ClinicalNotesModel $clinicalNotes;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->patients = new PatientsModel($db);
        $this->clinicalNotes = new ClinicalNotesModel($db);
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
        $latestNotes = $this->clinicalNotes->latestByCompany($companyId);
        $latestByPatient = [];
        foreach ($latestNotes as $note) {
            $patientId = (int)$note['patient_id'];
            if (!isset($latestByPatient[$patientId])) {
                $latestByPatient[$patientId] = $note;
            }
        }
        $records = [];
        foreach ($patients as $patient) {
            $latestNote = $latestByPatient[(int)$patient['id']] ?? null;
            $records[] = [
                'id' => $patient['id'],
                'patient' => $patient['name'],
                'last_visit' => $latestNote['note_date'] ?? null,
                'status' => $patient['status'] ?: 'Sin estado',
                'professional' => $latestNote['professional_name'] ?? 'Sin asignar',
            ];
        }
        $this->render('clinical/index', [
            'title' => 'Historial clínico',
            'subtitle' => 'Clínica',
            'records' => $records,
        ]);
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $notes = $this->clinicalNotes->forPatient($companyId, $patientId);
        $this->render('clinical/show', [
            'title' => 'Ficha clínica',
            'subtitle' => 'Historial clínico',
            'patientId' => $patientId,
            'patient' => $patient,
            'notes' => $notes,
        ]);
    }

    public function createNote(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }
        $this->render('clinical/create-note', [
            'title' => 'Nueva nota clínica',
            'subtitle' => 'Historial clínico',
            'patientId' => $patientId,
            'patient' => $patient,
        ]);
    }

    public function storeNote(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=patients');
        }

        $noteDate = trim($_POST['note_date'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($noteDate === '' || $description === '') {
            flash('error', 'Completa la fecha y la descripción.');
            $this->redirect('index.php?route=clinical/note&patient_id=' . $patientId);
        }

        $this->clinicalNotes->create([
            'company_id' => $companyId,
            'patient_id' => $patientId,
            'note_date' => $noteDate,
            'session_label' => trim($_POST['session_label'] ?? ''),
            'description' => $description,
            'created_by' => Auth::user()['id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        audit($this->db, Auth::user()['id'], 'create', 'clinical_notes', $patientId);
        flash('success', 'Nota clínica registrada correctamente.');
        $this->redirect('index.php?route=clinical/show&patient_id=' . $patientId);
    }
}
