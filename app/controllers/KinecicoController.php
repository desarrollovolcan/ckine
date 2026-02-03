<?php

class KinecicoController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        $today = new DateTimeImmutable('today');
        $todayDate = $today->format('Y-m-d');
        $appointmentModel = new AppointmentModel($this->db);

        $todaySessions = array_map(function (array $session): array {
            return [
                'time' => (new DateTimeImmutable($session['start_at']))->format('H:i'),
                'patient' => trim($session['first_name'] . ' ' . $session['last_name']),
                'therapist' => trim($session['prof_name'] . ' ' . $session['prof_last']),
                'service' => $session['service_name'],
                'room' => $session['box_name'],
                'status' => $session['status'],
            ];
        }, $appointmentModel->allWithRelations(['date' => $todayDate]));

        $activePatients = (int)($this->db->fetch('SELECT COUNT(*) AS total FROM patients WHERE deleted_at IS NULL')['total'] ?? 0);
        $plansCount = (int)($this->db->fetch('SELECT COUNT(*) AS total FROM patient_evaluations')['total'] ?? 0);

        $startOfWeek = $today->modify('monday this week')->setTime(0, 0);
        $endOfWeek = $startOfWeek->modify('+7 days');
        $estimatedIncome = (float)($this->db->fetch(
            'SELECT COALESCE(SUM(s.price), 0) AS total
             FROM appointments a
             INNER JOIN services s ON s.id = a.service_id
             WHERE a.start_at >= :start_at AND a.start_at < :end_at',
            [
                'start_at' => $startOfWeek->format('Y-m-d H:i:s'),
                'end_at' => $endOfWeek->format('Y-m-d H:i:s'),
            ]
        )['total'] ?? 0);

        $today = new DateTimeImmutable('today');
        $todayDate = $today->format('Y-m-d');
        $appointmentModel = new AppointmentModel($this->db);

        $todaySessions = array_map(function (array $session): array {
            return [
                'time' => (new DateTimeImmutable($session['start_at']))->format('H:i'),
                'patient' => trim($session['first_name'] . ' ' . $session['last_name']),
                'therapist' => trim($session['prof_name'] . ' ' . $session['prof_last']),
                'service' => $session['service_name'],
                'room' => $session['box_name'],
                'status' => $session['status'],
            ];
        }, $appointmentModel->allWithRelations(['date' => $todayDate]));

        $activePatients = (int)($this->db->fetch('SELECT COUNT(*) AS total FROM patients WHERE deleted_at IS NULL')['total'] ?? 0);
        $plansCount = (int)($this->db->fetch('SELECT COUNT(*) AS total FROM patient_evaluations')['total'] ?? 0);

        $startOfWeek = $today->modify('monday this week')->setTime(0, 0);
        $endOfWeek = $startOfWeek->modify('+7 days');
        $estimatedIncome = (float)($this->db->fetch(
            'SELECT COALESCE(SUM(s.price), 0) AS total
             FROM appointments a
             INNER JOIN services s ON s.id = a.service_id
             WHERE a.start_at >= :start_at AND a.start_at < :end_at',
            [
                'start_at' => $startOfWeek->format('Y-m-d H:i:s'),
                'end_at' => $endOfWeek->format('Y-m-d H:i:s'),
            ]
        )['total'] ?? 0);

        $stats = [
            [
                'label' => 'Sesiones hoy',
                'value' => count($todaySessions),
                'trend' => 'Sesiones programadas para hoy',
                'icon' => 'calendar-check',
                'tone' => 'primary',
            ],
            [
                'label' => 'Pacientes activos',
                'value' => $activePatients,
                'trend' => 'Pacientes registrados en el centro',
                'icon' => 'users',
                'tone' => 'success',
            ],
            [
                'label' => 'Planes en seguimiento',
                'value' => $plansCount,
                'trend' => 'Planes clínicos activos',
                'icon' => 'clipboard-list',
                'tone' => 'warning',
            ],
            [
                'label' => 'Ingresos estimados',
                'value' => format_currency($estimatedIncome),
                'trend' => 'Proyección semanal',
                'icon' => 'cash',
                'tone' => 'info',
            ],
        ];

        $patients = $this->db->fetchAll(
            'SELECT p.*, 
                    (SELECT plan FROM patient_evaluations e WHERE e.patient_id = p.id ORDER BY e.created_at DESC LIMIT 1) AS plan,
                    (SELECT status FROM appointments a WHERE a.patient_id = p.id ORDER BY a.start_at DESC LIMIT 1) AS last_status,
                    (SELECT COUNT(*) FROM appointments a WHERE a.patient_id = p.id) AS total_sessions
             FROM patients p
             WHERE p.deleted_at IS NULL
             ORDER BY p.created_at DESC
             LIMIT 5'
        );

        $treatmentPlans = $this->db->fetchAll(
            'SELECT e.*, p.first_name, p.last_name
             FROM patient_evaluations e
             INNER JOIN patients p ON p.id = e.patient_id
             ORDER BY e.created_at DESC
             LIMIT 6'
        );

        $payments = $this->db->fetchAll(
            'SELECT kp.*, p.first_name, p.last_name, s.name AS service_name
             FROM kine_payments kp
             LEFT JOIN patients p ON p.id = kp.patient_id
             LEFT JOIN services s ON s.id = kp.service_id
             ORDER BY kp.created_at DESC
             LIMIT 5'
        );

        $dayOfWeek = (int)$today->format('N');
        $staff = $this->db->fetchAll(
            'SELECT pr.*, sch.start_time, sch.end_time
             FROM professionals pr
             LEFT JOIN professional_schedules sch ON sch.professional_id = pr.id AND sch.day_of_week = :day_of_week
             WHERE pr.active = 1
             ORDER BY pr.first_name, pr.last_name',
            ['day_of_week' => $dayOfWeek]
        );

        $patientsList = (new PatientModel($this->db))->allActive();
        $professionalsList = (new ProfessionalModel($this->db))->allActive();
        $servicesList = (new ServiceModel($this->db))->allActive();
        $boxesList = (new BoxModel($this->db))->allActive();

        $this->render('kinecico/index', [
            'title' => 'Centro Kinésico',
            'pageTitle' => 'Centro Kinésico',
            'stats' => $stats,
            'todaySessions' => $todaySessions,
            'patients' => $patients,
            'treatmentPlans' => $treatmentPlans,
            'payments' => $payments,
            'staff' => $staff,
            'patientsList' => $patientsList,
            'professionalsList' => $professionalsList,
            'servicesList' => $servicesList,
            'boxesList' => $boxesList,
            'todayDate' => $todayDate,
        ]);
    }

    public function storeSession(): void
    {
        $this->requireLogin();
        verify_csrf();
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $professionalId = (int)($_POST['professional_id'] ?? 0);
        $serviceId = (int)($_POST['service_id'] ?? 0);
        $boxId = (int)($_POST['box_id'] ?? 0);
        $date = $_POST['date'] ?? '';
        $time = $_POST['time'] ?? '';
        $status = $_POST['status'] ?? 'pendiente';
        $notes = trim($_POST['notes'] ?? '');

        if ($patientId === 0 || $professionalId === 0 || $serviceId === 0 || $boxId === 0 || $date === '' || $time === '') {
            flash('error', 'Completa todos los campos obligatorios para la sesión.');
            $this->redirect('index.php?route=kinecico');
        }

        $service = $this->db->fetch('SELECT * FROM services WHERE id = :id', ['id' => $serviceId]);
        $duration = (int)($service['duration_minutes'] ?? 60);
        $startAt = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
        if (!$startAt) {
            flash('error', 'Fecha u hora inválida.');
            $this->redirect('index.php?route=kinecico');
        }
        $endAt = $startAt->modify('+' . $duration . ' minutes');

        $appointmentModel = new AppointmentModel($this->db);
        if ($appointmentModel->hasConflict($professionalId, $boxId, $startAt->format('Y-m-d H:i:s'), $endAt->format('Y-m-d H:i:s'))) {
            flash('error', 'Existe un conflicto de horario para el profesional o box seleccionado.');
            $this->redirect('index.php?route=kinecico');
        }

        $this->db->execute(
            'INSERT INTO appointments (patient_id, professional_id, box_id, service_id, start_at, end_at, status, notes, created_at, updated_at)
             VALUES (:patient_id, :professional_id, :box_id, :service_id, :start_at, :end_at, :status, :notes, NOW(), NOW())',
            [
                'patient_id' => $patientId,
                'professional_id' => $professionalId,
                'box_id' => $boxId,
                'service_id' => $serviceId,
                'start_at' => $startAt->format('Y-m-d H:i:s'),
                'end_at' => $endAt->format('Y-m-d H:i:s'),
                'status' => $status,
                'notes' => $notes,
            ]
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'appointments', (int)$this->db->lastInsertId());
        flash('success', 'Sesión registrada en la agenda del centro.');
        $this->redirect('index.php?route=kinecico');
    }

    public function storePatient(): void
    {
        $this->requireLogin();
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $rut = normalize_rut($_POST['rut'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $reason = trim($_POST['reason'] ?? '');

        if ($name === '') {
            flash('error', 'Ingresa el nombre del paciente.');
            $this->redirect('index.php?route=kinecico');
        }
        if ($rut !== '' && !is_valid_rut($rut)) {
            flash('error', 'RUT inválido.');
            $this->redirect('index.php?route=kinecico');
        }
        if ($email !== '' && !Validator::email($email)) {
            flash('error', 'Email inválido.');
            $this->redirect('index.php?route=kinecico');
        }

        $parts = preg_split('/\s+/', $name, 2);
        $firstName = $parts[0] ?? '';
        $lastName = $parts[1] ?? $parts[0] ?? '';

        $payload = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'rut' => $rut,
            'birth_date' => null,
            'phone' => $phone,
            'email' => $email,
            'address' => '',
            'insurance' => '',
            'emergency_contact_name' => '',
            'emergency_contact_phone' => '',
            'notes' => $reason,
        ];

        $this->db->execute(
            'INSERT INTO patients (first_name, last_name, rut, birth_date, phone, email, address, insurance, emergency_contact_name, emergency_contact_phone, notes, created_at, updated_at)
             VALUES (:first_name, :last_name, :rut, :birth_date, :phone, :email, :address, :insurance, :emergency_contact_name, :emergency_contact_phone, :notes, NOW(), NOW())',
            $payload
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'patients', (int)$this->db->lastInsertId(), $payload);
        flash('success', 'Paciente registrado correctamente.');
        $this->redirect('index.php?route=kinecico');
    }

    public function storePlan(): void
    {
        $this->requireLogin();
        verify_csrf();
        $patientId = (int)($_POST['patient_id'] ?? 0);
        $reason = trim($_POST['reason'] ?? '');
        $diagnosis = trim($_POST['diagnosis'] ?? '');
        $objectives = trim($_POST['objectives'] ?? '');
        $plan = trim($_POST['plan'] ?? '');
        $appointmentId = ($_POST['appointment_id'] ?? '') !== '' ? (int)$_POST['appointment_id'] : null;

        if ($patientId === 0 || $plan === '') {
            flash('error', 'Selecciona un paciente y describe el plan terapéutico.');
            $this->redirect('index.php?route=kinecico');
        }

        $this->db->execute(
            'INSERT INTO patient_evaluations (patient_id, appointment_id, reason, history, diagnosis, objectives, plan, created_at, updated_at)
             VALUES (:patient_id, :appointment_id, :reason, :history, :diagnosis, :objectives, :plan, NOW(), NOW())',
            [
                'patient_id' => $patientId,
                'appointment_id' => $appointmentId,
                'reason' => $reason,
                'history' => null,
                'diagnosis' => $diagnosis,
                'objectives' => $objectives,
                'plan' => $plan,
            ]
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'patient_evaluations', (int)$this->db->lastInsertId(), [
            'patient_id' => $patientId,
        ]);
        flash('success', 'Plan terapéutico actualizado.');
        $this->redirect('index.php?route=kinecico');
    }

    public function storePayment(): void
    {
        $this->requireLogin();
        verify_csrf();
        $patientId = ($_POST['payment_patient'] ?? '') !== '' ? (int)$_POST['payment_patient'] : null;
        $serviceId = ($_POST['service_id'] ?? '') !== '' ? (int)$_POST['service_id'] : null;
        $amountRaw = trim($_POST['amount'] ?? '');
        $method = trim($_POST['method'] ?? '');
        $status = trim($_POST['payment_status'] ?? 'pagado');

        $amountValue = (float)preg_replace('/[^0-9]/', '', $amountRaw);
        if ($amountValue <= 0) {
            flash('error', 'Ingresa un monto válido.');
            $this->redirect('index.php?route=kinecico');
        }

        $this->db->execute(
            'INSERT INTO kine_payments (patient_id, service_id, amount, method, status, created_at)
             VALUES (:patient_id, :service_id, :amount, :method, :status, NOW())',
            [
                'patient_id' => $patientId,
                'service_id' => $serviceId,
                'amount' => $amountValue,
                'method' => $method,
                'status' => $status,
            ]
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'kine_payments', (int)$this->db->lastInsertId());
        flash('success', 'Pago registrado en tesorería.');
        $this->redirect('index.php?route=kinecico');
    }
}
