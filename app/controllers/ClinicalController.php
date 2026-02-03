<?php

class ClinicalController extends Controller
{
    private PatientsModel $patients;
    private ProfessionalsModel $professionals;
    private ClinicalNotesModel $clinicalNotes;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->patients = new PatientsModel($db);
        $this->professionals = new ProfessionalsModel($db);
        $this->clinicalNotes = new ClinicalNotesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $records = $this->db->fetchAll(
            'SELECT patients.id,
                    patients.name AS patient,
                    patients.status,
                    MAX(clinical_notes.note_date) AS last_visit,
                    MAX(professionals.name) AS professional
             FROM patients
             LEFT JOIN clinical_notes ON clinical_notes.patient_id = patients.id AND clinical_notes.deleted_at IS NULL
             LEFT JOIN professionals ON clinical_notes.professional_id = professionals.id
             WHERE patients.deleted_at IS NULL AND patients.company_id = :company_id
             GROUP BY patients.id, patients.name, patients.status
             ORDER BY last_visit DESC, patients.id DESC',
            ['company_id' => $companyId]
        );
        $this->render('clinical/index', [
            'title' => 'Historial clínico',
            'subtitle' => 'Clínica',
            'records' => $records,
        ]);
    }

    public function show(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $patient = $companyId ? $this->patients->findByCompany($companyId, $patientId) : null;
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=clinical');
        }
        $notes = $this->clinicalNotes->byPatient($companyId, $patientId);
        $this->render('clinical/show', [
            'title' => 'Ficha clínica',
            'subtitle' => 'Historial clínico',
            'patient' => $patient,
            'notes' => $notes,
        ]);
    }

    public function createNote(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $patient = $companyId ? $this->patients->findByCompany($companyId, $patientId) : null;
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=clinical');
        }
        $professionals = $this->professionals->active($companyId);
        $this->render('clinical/create-note', [
            'title' => 'Nueva nota clínica',
            'subtitle' => 'Historial clínico',
            'patient' => $patient,
            'professionals' => $professionals,
        ]);
    }

    public function storeNote(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = current_company_id();
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $patient = $companyId ? $this->patients->findByCompany($companyId, $patientId) : null;
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=clinical');
        }
        $noteDate = $_POST['note_date'] ?? '';
        $title = trim($_POST['title'] ?? '');
        if ($noteDate === '' || $title === '') {
            flash('error', 'Completa la fecha y el título de la nota.');
            $this->redirect('index.php?route=clinical/note&patient_id=' . $patientId);
        }
        $noteId = $this->clinicalNotes->create([
            'company_id' => $companyId,
            'patient_id' => $patientId,
            'professional_id' => (int)($_POST['professional_id'] ?? 0) ?: null,
            'note_date' => $noteDate,
            'title' => $title,
            'description' => trim($_POST['description'] ?? '') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'clinical_notes', $noteId);
        flash('success', 'Nota clínica registrada.');
        $this->redirect('index.php?route=clinical/show&patient_id=' . $patientId);
    }
}
