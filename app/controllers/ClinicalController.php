<?php

class ClinicalController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $records = [
            ['id' => 1001, 'patient' => 'María López', 'last_visit' => '2024-05-01', 'status' => 'En tratamiento', 'professional' => 'Dra. Paula Fuentes'],
            ['id' => 1002, 'patient' => 'Carlos Rivas', 'last_visit' => '2024-04-28', 'status' => 'Alta parcial', 'professional' => 'Sr. Diego Valdés'],
            ['id' => 1003, 'patient' => 'Josefina Araya', 'last_visit' => '2024-04-20', 'status' => 'Evaluación inicial', 'professional' => 'Lic. Fernanda Rojas'],
        ];
        $this->render('clinical/index', [
            'title' => 'Historial clínico',
            'subtitle' => 'Clínica',
            'records' => $records,
        ]);
    }

    public function show(): void
    {
        $this->requireLogin();
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $this->render('clinical/show', [
            'title' => 'Ficha clínica',
            'subtitle' => 'Historial clínico',
            'patientId' => $patientId,
        ]);
    }

    public function createNote(): void
    {
        $this->requireLogin();
        $patientId = (int)($_GET['patient_id'] ?? 0);
        $this->render('clinical/create-note', [
            'title' => 'Nueva nota clínica',
            'subtitle' => 'Historial clínico',
            'patientId' => $patientId,
        ]);
    }
}
