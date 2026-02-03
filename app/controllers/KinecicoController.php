<?php

class KinecicoController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $companyId = current_company_id();
        if (!$companyId) {
            flash('error', 'Selecciona una empresa.');
            $this->redirect('index.php?route=auth/switch-company');
        }

        $stats = [
            [
                'label' => 'Sesiones hoy',
                'value' => 18,
                'trend' => '8% más que ayer',
                'icon' => 'calendar-check',
                'tone' => 'primary',
            ],
            [
                'label' => 'Pacientes activos',
                'value' => 126,
                'trend' => '12 nuevos este mes',
                'icon' => 'users',
                'tone' => 'success',
            ],
            [
                'label' => 'Planes en curso',
                'value' => 42,
                'trend' => '5 por cerrar',
                'icon' => 'clipboard-list',
                'tone' => 'warning',
            ],
            [
                'label' => 'Ingresos estimados',
                'value' => format_currency(1854000),
                'trend' => 'Facturación semanal',
                'icon' => 'cash',
                'tone' => 'info',
            ],
        ];

        $todaySessions = [
            [
                'time' => '09:00',
                'patient' => 'Camila Rojas',
                'therapist' => 'Dra. Valentina Mora',
                'service' => 'Rehabilitación postoperatoria',
                'room' => 'Box 1',
                'status' => 'confirmada',
            ],
            [
                'time' => '10:30',
                'patient' => 'Sebastián Pinto',
                'therapist' => 'Lic. Diego Araya',
                'service' => 'Kinesiología deportiva',
                'room' => 'Box 3',
                'status' => 'pendiente',
            ],
            [
                'time' => '12:00',
                'patient' => 'María José Lagos',
                'therapist' => 'Dra. Carla Fuentes',
                'service' => 'Terapia respiratoria',
                'room' => 'Box 2',
                'status' => 'confirmada',
            ],
            [
                'time' => '15:30',
                'patient' => 'Jorge Escobar',
                'therapist' => 'Lic. Daniel Orellana',
                'service' => 'Reeducación postural',
                'room' => 'Gimnasio',
                'status' => 'evaluación',
            ],
        ];

        $patients = [
            [
                'name' => 'Camila Rojas',
                'plan' => 'Post cirugía rodilla',
                'sessions' => '6/12',
                'risk' => 'bajo',
                'phone' => '+56 9 8123 4567',
            ],
            [
                'name' => 'Sebastián Pinto',
                'plan' => 'Retorno al deporte',
                'sessions' => '3/10',
                'risk' => 'medio',
                'phone' => '+56 9 6789 1122',
            ],
            [
                'name' => 'María José Lagos',
                'plan' => 'Control respiratorio',
                'sessions' => '8/8',
                'risk' => 'alto',
                'phone' => '+56 9 9988 7766',
            ],
        ];

        $treatmentPlans = [
            [
                'name' => 'Reeducación postural global',
                'patient' => 'Jorge Escobar',
                'progress' => 55,
                'next' => 'Evaluación funcional',
                'status' => 'En seguimiento',
            ],
            [
                'name' => 'Rehabilitación hombro',
                'patient' => 'Isidora Sáez',
                'progress' => 72,
                'next' => 'Sesión de fortalecimiento',
                'status' => 'Evolución positiva',
            ],
            [
                'name' => 'Kinesiología respiratoria',
                'patient' => 'María José Lagos',
                'progress' => 90,
                'next' => 'Alta médica',
                'status' => 'Próximo cierre',
            ],
        ];

        $payments = [
            [
                'patient' => 'Camila Rojas',
                'service' => 'Paquete 12 sesiones',
                'amount' => 240000,
                'status' => 'pagado',
            ],
            [
                'patient' => 'Sebastián Pinto',
                'service' => 'Plan deportivo',
                'amount' => 180000,
                'status' => 'pendiente',
            ],
            [
                'patient' => 'Jorge Escobar',
                'service' => 'Evaluación inicial',
                'amount' => 35000,
                'status' => 'pagado',
            ],
        ];

        $staff = [
            [
                'name' => 'Dra. Valentina Mora',
                'role' => 'Directora clínica',
                'shift' => '08:00 - 16:00',
            ],
            [
                'name' => 'Lic. Diego Araya',
                'role' => 'Kinesiólogo deportivo',
                'shift' => '10:00 - 19:00',
            ],
            [
                'name' => 'Dra. Carla Fuentes',
                'role' => 'Kinesiología respiratoria',
                'shift' => '09:00 - 17:00',
            ],
        ];

        $this->render('kinecico/index', [
            'title' => 'Centro Kinésico',
            'pageTitle' => 'Centro Kinésico',
            'stats' => $stats,
            'todaySessions' => $todaySessions,
            'patients' => $patients,
            'treatmentPlans' => $treatmentPlans,
            'payments' => $payments,
            'staff' => $staff,
        ]);
    }

    public function storeSession(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Sesión registrada en la agenda del centro.');
        $this->redirect('index.php?route=kinecico');
    }

    public function storePatient(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Paciente registrado correctamente.');
        $this->redirect('index.php?route=kinecico');
    }

    public function storePlan(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Plan terapéutico actualizado.');
        $this->redirect('index.php?route=kinecico');
    }

    public function storePayment(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Pago registrado en tesorería.');
        $this->redirect('index.php?route=kinecico');
    }
}
