<?php

class PatientsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $patients = [
            ['id' => 1001, 'name' => 'María López', 'rut' => '12.345.678-9', 'birthdate' => '1990-04-12', 'phone' => '+56 9 1234 5678', 'email' => 'maria.lopez@example.com', 'status' => 'Activo'],
            ['id' => 1002, 'name' => 'Carlos Rivas', 'rut' => '9.876.543-2', 'birthdate' => '1985-11-30', 'phone' => '+56 9 9876 1234', 'email' => 'carlos.rivas@example.com', 'status' => 'En seguimiento'],
            ['id' => 1003, 'name' => 'Josefina Araya', 'rut' => '18.223.445-1', 'birthdate' => '2000-02-08', 'phone' => '+56 9 1111 2233', 'email' => 'josefina.araya@example.com', 'status' => 'Nuevo'],
        ];
        $this->render('patients/index', [
            'title' => 'Pacientes',
            'subtitle' => 'Clínica',
            'patients' => $patients,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('patients/create', [
            'title' => 'Nuevo paciente',
            'subtitle' => 'Pacientes',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Paciente creado correctamente (demo).');
        $this->redirect('index.php?route=patients');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $patientId = (int)($_GET['id'] ?? 0);
        $this->render('patients/edit', [
            'title' => 'Editar paciente',
            'subtitle' => 'Pacientes',
            'patientId' => $patientId,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Paciente actualizado correctamente (demo).');
        $this->redirect('index.php?route=patients');
    }

    public function show(): void
    {
        $this->requireLogin();
        $patientId = (int)($_GET['id'] ?? 0);
        $this->render('patients/show', [
            'title' => 'Ficha del paciente',
            'subtitle' => 'Pacientes',
            'patientId' => $patientId,
        ]);
    }
}
