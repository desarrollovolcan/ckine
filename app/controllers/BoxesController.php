<?php

class BoxesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $boxes = [
            ['id' => 1, 'name' => 'Box 1', 'capacity' => '2 pacientes', 'equipment' => 'Camilla, electroestimulación', 'status' => 'Disponible'],
            ['id' => 2, 'name' => 'Box 2', 'capacity' => '1 paciente', 'equipment' => 'Camilla, compresas', 'status' => 'En uso'],
            ['id' => 3, 'name' => 'Sala funcional', 'capacity' => '4 pacientes', 'equipment' => 'Bandas, colchonetas', 'status' => 'Disponible'],
        ];
        $this->render('boxes/index', [
            'title' => 'Box y salas',
            'subtitle' => 'Clínica',
            'boxes' => $boxes,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('boxes/create', [
            'title' => 'Nuevo box',
            'subtitle' => 'Box y salas',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Box creado correctamente (demo).');
        $this->redirect('index.php?route=boxes');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $boxId = (int)($_GET['id'] ?? 0);
        $this->render('boxes/edit', [
            'title' => 'Editar box',
            'subtitle' => 'Box y salas',
            'boxId' => $boxId,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        flash('success', 'Box actualizado correctamente (demo).');
        $this->redirect('index.php?route=boxes');
    }

    public function show(): void
    {
        $this->requireLogin();
        $boxId = (int)($_GET['id'] ?? 0);
        $this->render('boxes/show', [
            'title' => 'Detalle del box',
            'subtitle' => 'Box y salas',
            'boxId' => $boxId,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $boxId = (int)($_POST['id'] ?? 0);
        flash('success', "Box {$boxId} eliminado correctamente (demo).");
        $this->redirect('index.php?route=boxes');
    }
}
