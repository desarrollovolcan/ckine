<?php

declare(strict_types=1);

class DashboardController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();

        $appointments = $this->db->fetchAll(
            'SELECT a.*, p.first_name, p.last_name, pr.first_name AS prof_name, pr.last_name AS prof_last
             FROM appointments a
             INNER JOIN patients p ON p.id = a.patient_id
             INNER JOIN professionals pr ON pr.id = a.professional_id
             WHERE DATE(a.start_at) = CURDATE()
             ORDER BY a.start_at ASC'
        );

        $stats = [
            'appointments_today' => count($appointments),
            'patients' => (int)($this->db->fetch('SELECT COUNT(*) AS total FROM patients WHERE deleted_at IS NULL')['total'] ?? 0),
            'professionals' => (int)($this->db->fetch('SELECT COUNT(*) AS total FROM professionals WHERE active = 1')['total'] ?? 0),
            'pending' => (int)($this->db->fetch('SELECT COUNT(*) AS total FROM appointments WHERE status = "pendiente"')['total'] ?? 0),
        ];

        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'pageTitle' => 'Panel Centro Kinésico',
            'appointments' => $appointments,
            'stats' => $stats,
        ]);
    }
}
