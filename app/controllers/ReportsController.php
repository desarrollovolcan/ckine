<?php

declare(strict_types=1);

class ReportsController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $this->render('reports/index', [
            'title' => 'Reportes',
            'pageTitle' => 'Reportes',
            'report' => null,
        ]);
    }

    public function generate(): void
    {
        $this->requireLogin();
        verify_csrf();

        $type = $_POST['type'] ?? 'agenda';
        $start = $_POST['start_date'] ?? date('Y-m-d');
        $end = $_POST['end_date'] ?? date('Y-m-d');

        $data = [];
        if ($type === 'agenda') {
            $data = $this->db->fetchAll(
                'SELECT a.start_at, a.status, p.first_name, p.last_name, pr.first_name AS prof_name, pr.last_name AS prof_last, b.name AS box_name
                 FROM appointments a
                 INNER JOIN patients p ON p.id = a.patient_id
                 INNER JOIN professionals pr ON pr.id = a.professional_id
                 INNER JOIN boxes b ON b.id = a.box_id
                 WHERE DATE(a.start_at) BETWEEN :start AND :end
                 ORDER BY a.start_at ASC',
                ['start' => $start, 'end' => $end]
            );
        }
        if ($type === 'no_show') {
            $data = $this->db->fetchAll(
                'SELECT DATE(a.start_at) AS fecha, COUNT(*) AS total
                 FROM appointments a
                 WHERE a.status = "no_asistio" AND DATE(a.start_at) BETWEEN :start AND :end
                 GROUP BY DATE(a.start_at)
                 ORDER BY fecha DESC',
                ['start' => $start, 'end' => $end]
            );
        }
        if ($type === 'ocupacion') {
            $data = $this->db->fetchAll(
                'SELECT b.name, COUNT(*) AS total
                 FROM appointments a
                 INNER JOIN boxes b ON b.id = a.box_id
                 WHERE DATE(a.start_at) BETWEEN :start AND :end
                 GROUP BY b.name
                 ORDER BY total DESC',
                ['start' => $start, 'end' => $end]
            );
        }
        if ($type === 'nuevos') {
            $data = $this->db->fetchAll(
                'SELECT DATE(created_at) AS fecha, COUNT(*) AS total
                 FROM patients
                 WHERE DATE(created_at) BETWEEN :start AND :end
                 GROUP BY DATE(created_at)
                 ORDER BY fecha DESC',
                ['start' => $start, 'end' => $end]
            );
        }

        $this->render('reports/index', [
            'title' => 'Reportes',
            'pageTitle' => 'Reportes',
            'report' => [
                'type' => $type,
                'start' => $start,
                'end' => $end,
                'data' => $data,
            ],
        ]);
    }
}
