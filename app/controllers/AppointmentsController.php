<?php

class AppointmentsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $appointments = [
            ['id' => 501, 'patient' => 'María López', 'professional' => 'Dra. Paula Fuentes', 'date' => '2024-05-12', 'time' => '09:00', 'box' => 'Box 1', 'status' => 'Confirmada'],
            ['id' => 502, 'patient' => 'Carlos Rivas', 'professional' => 'Sr. Diego Valdés', 'date' => '2024-05-12', 'time' => '10:30', 'box' => 'Box 2', 'status' => 'Pendiente'],
            ['id' => 503, 'patient' => 'Josefina Araya', 'professional' => 'Lic. Fernanda Rojas', 'date' => '2024-05-13', 'time' => '12:00', 'box' => 'Sala funcional', 'status' => 'En espera'],
        ];
        $this->render('appointments/index', [
            'title' => 'Citas',
            'subtitle' => 'Agenda',
            'appointments' => $appointments,
        ]);
    }

    public function calendar(): void
    {
        $this->requireLogin();
        $this->render('appointments/calendar', [
            'title' => 'Calendario de citas',
            'subtitle' => 'Agenda',
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('appointments/create', [
            'title' => 'Nueva cita',
            'subtitle' => 'Agenda',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Cita agendada correctamente (demo).');
        $this->redirect('index.php?route=appointments');
    }
}
