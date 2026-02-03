<?php

class AuditController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $entries = [
            ['date' => '2024-05-10 09:14', 'user' => 'admin', 'action' => 'Inicio de sesión', 'module' => 'Autenticación'],
            ['date' => '2024-05-10 10:02', 'user' => 'recepcion', 'action' => 'Creó paciente', 'module' => 'Pacientes'],
            ['date' => '2024-05-10 11:45', 'user' => 'kinesiologo', 'action' => 'Actualizó nota clínica', 'module' => 'Historial clínico'],
        ];
        $this->render('audit/index', [
            'title' => 'Auditoría y logs',
            'subtitle' => 'Administración',
            'entries' => $entries,
        ]);
    }
}
