<?php

class ProfessionalsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $professionals = [
            ['id' => 201, 'name' => 'Dra. Paula Fuentes', 'specialty' => 'Kinesiología deportiva', 'email' => 'paula.fuentes@example.com', 'phone' => '+56 9 2222 3344', 'status' => 'Activo'],
            ['id' => 202, 'name' => 'Sr. Diego Valdés', 'specialty' => 'Rehabilitación neurológica', 'email' => 'diego.valdes@example.com', 'phone' => '+56 9 3333 4455', 'status' => 'Activo'],
            ['id' => 203, 'name' => 'Lic. Fernanda Rojas', 'specialty' => 'Kinesiología respiratoria', 'email' => 'fernanda.rojas@example.com', 'phone' => '+56 9 4444 5566', 'status' => 'En pausa'],
        ];
        $this->render('professionals/index', [
            'title' => 'Profesionales',
            'subtitle' => 'Clínica',
            'professionals' => $professionals,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('professionals/create', [
            'title' => 'Nuevo profesional',
            'subtitle' => 'Profesionales',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Profesional creado correctamente (demo).');
        $this->redirect('index.php?route=professionals');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $professionalId = (int)($_GET['id'] ?? 0);
        $this->render('professionals/edit', [
            'title' => 'Editar profesional',
            'subtitle' => 'Profesionales',
            'professionalId' => $professionalId,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Profesional actualizado correctamente (demo).');
        $this->redirect('index.php?route=professionals');
    }

    public function show(): void
    {
        $this->requireLogin();
        $professionalId = (int)($_GET['id'] ?? 0);
        $this->render('professionals/show', [
            'title' => 'Perfil profesional',
            'subtitle' => 'Profesionales',
            'professionalId' => $professionalId,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $professionalId = (int)($_POST['id'] ?? 0);
        flash('success', "Profesional {$professionalId} eliminado correctamente (demo).");
        $this->redirect('index.php?route=professionals');
    }
}
