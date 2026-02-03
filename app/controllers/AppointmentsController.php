<?php

class AppointmentsController extends Controller
{
    private AppointmentsModel $appointments;
    private PatientsModel $patients;
    private ProfessionalsModel $professionals;
    private BoxesModel $boxes;

    public function __construct(array $config, Database $db)
    {
        parent::__construct($config, $db);
        $this->appointments = new AppointmentsModel($db);
        $this->patients = new PatientsModel($db);
        $this->professionals = new ProfessionalsModel($db);
        $this->boxes = new BoxesModel($db);
    }

    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $appointments = $this->appointments->active($companyId);
        $this->render('appointments/index', [
            'title' => 'Citas',
            'subtitle' => 'Agenda',
            'appointments' => $appointments,
        ]);
    }

    public function calendar(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $upcoming = $this->appointments->upcoming($companyId, 8);
        $this->render('appointments/calendar', [
            'title' => 'Calendario de citas',
            'subtitle' => 'Agenda',
            'upcoming' => $upcoming,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa para continuar.');
            $this->redirect('index.php?route=auth/switch-company');
        }
        $patients = $this->patients->active($companyId);
        $professionals = $this->professionals->active($companyId);
        $boxes = $this->boxes->active($companyId);
        $this->render('appointments/create', [
            'title' => 'Nueva cita',
            'subtitle' => 'Agenda',
            'patients' => $patients,
            'professionals' => $professionals,
            'boxes' => $boxes,
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
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $professionalId = (int)($_POST['professional_id'] ?? 0);
        $boxId = (int)($_POST['box_id'] ?? 0);
        $date = $_POST['appointment_date'] ?? '';
        $time = $_POST['appointment_time'] ?? '';
        if ($patientId === 0 || $professionalId === 0 || $date === '' || $time === '') {
            flash('error', 'Completa los campos obligatorios de la cita.');
            $this->redirect('index.php?route=appointments/create');
        }
        if (!$this->patients->findByCompany($companyId, $patientId)) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=appointments/create');
        }
        if (!$this->professionals->findByCompany($companyId, $professionalId)) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=appointments/create');
        }
        if ($boxId !== 0 && !$this->boxes->findByCompany($companyId, $boxId)) {
            flash('error', 'Box no encontrado.');
            $this->redirect('index.php?route=appointments/create');
        }
        $data = [
            'company_id' => $companyId,
            'patient_id' => $patientId,
            'professional_id' => $professionalId,
            'box_id' => $boxId ?: null,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'status' => $_POST['status'] ?? 'Pendiente',
            'notes' => trim($_POST['notes'] ?? '') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $appointmentId = $this->appointments->create($data);
        audit($this->db, Auth::user()['id'], 'create', 'appointments', $appointmentId);
        flash('success', 'Cita agendada correctamente.');
        $this->redirect('index.php?route=appointments');
    }
}
