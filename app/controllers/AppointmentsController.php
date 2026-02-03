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
        $appointments = $this->appointments->activeByCompany($companyId);
        $this->render('appointments/index', [
            'title' => 'Citas',
            'subtitle' => 'Agenda',
            'appointments' => $appointments,
        ]);
    }

    public function calendar(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
        $today = new DateTimeImmutable('today');
        $startDate = $today->format('Y-m-d');
        $endDate = $today->modify('+6 days')->format('Y-m-d');
        $appointments = $this->appointments->byDateRange($companyId, $startDate, $endDate);
        $appointmentsByDate = [];
        foreach ($appointments as $appointment) {
            $appointmentsByDate[$appointment['appointment_date']][] = $appointment;
        }
        $calendarDays = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $today->modify("+{$i} days")->format('Y-m-d');
            $calendarDays[] = [
                'date' => $date,
                'appointments' => $appointmentsByDate[$date] ?? [],
            ];
        }
        $todayAppointments = $appointmentsByDate[$startDate] ?? [];
        $this->render('appointments/calendar', [
            'title' => 'Calendario de citas',
            'subtitle' => 'Agenda',
            'calendarDays' => $calendarDays,
            'todayAppointments' => $todayAppointments,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $companyId = $this->requireCompany();
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
        $companyId = $this->requireCompany();
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $professionalId = (int)($_POST['professional_id'] ?? 0);
        $boxId = (int)($_POST['box_id'] ?? 0);
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');
        $status = trim($_POST['status'] ?? 'Pendiente');
        $notes = trim($_POST['notes'] ?? '');
        $allowedStatuses = ['Pendiente', 'Confirmada', 'En espera', 'Cancelada'];

        $patient = $this->patients->findForCompany($patientId, $companyId);
        if (!$patient) {
            flash('error', 'Paciente no encontrado.');
            $this->redirect('index.php?route=appointments/create');
        }
        $professional = $this->professionals->findForCompany($professionalId, $companyId);
        if (!$professional) {
            flash('error', 'Profesional no encontrado.');
            $this->redirect('index.php?route=appointments/create');
        }
        if ($boxId > 0) {
            $box = $this->boxes->findForCompany($boxId, $companyId);
            if (!$box) {
                flash('error', 'Box no encontrado.');
                $this->redirect('index.php?route=appointments/create');
            }
        } else {
            $boxId = null;
        }
        if ($date === '' || $time === '') {
            flash('error', 'Selecciona fecha y hora.');
            $this->redirect('index.php?route=appointments/create');
        }
        if (!in_array($status, $allowedStatuses, true)) {
            flash('error', 'Selecciona un estado válido.');
            $this->redirect('index.php?route=appointments/create');
        }
        $duplicate = $this->db->fetch(
            'SELECT id FROM appointments WHERE company_id = :company_id AND patient_id = :patient_id AND appointment_date = :date AND appointment_time = :time AND deleted_at IS NULL',
            [
                'company_id' => $companyId,
                'patient_id' => $patientId,
                'date' => $date,
                'time' => $time,
            ]
        );
        if ($duplicate) {
            flash('error', 'Ya existe una cita para este paciente en la misma fecha y hora.');
            $this->redirect('index.php?route=appointments/create');
        }

        $this->appointments->create([
            'company_id' => $companyId,
            'patient_id' => $patientId,
            'professional_id' => $professionalId,
            'box_id' => $boxId,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'status' => $status,
            'notes' => $notes,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        audit($this->db, Auth::user()['id'], 'create', 'appointments');
        flash('success', 'Cita agendada correctamente.');
        $this->redirect('index.php?route=appointments');
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $companyId = $this->requireCompany();
        $appointmentId = (int)($_POST['id'] ?? 0);
        $appointment = $this->appointments->findForCompany($appointmentId, $companyId);
        if (!$appointment) {
            flash('error', 'Cita no encontrada.');
            $this->redirect('index.php?route=appointments');
        }
        $this->appointments->markDeleted($appointmentId, $companyId);
        audit($this->db, Auth::user()['id'], 'delete', 'appointments', $appointmentId);
        flash('success', 'Cita eliminada correctamente.');
        $this->redirect('index.php?route=appointments');
    }
}
