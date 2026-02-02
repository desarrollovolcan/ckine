<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Models\Box;
use App\Models\Professional;

class ReportsController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('reports.view')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $date = Request::input('date') ?: date('Y-m-d');
        $db = DB::connection();
        $stmt = $db->prepare('SELECT appointments.*, patients.first_name, patients.last_name, users.name AS professional_name, boxes.name AS box_name, services.name AS service_name
            FROM appointments
            JOIN patients ON patients.id = appointments.patient_id
            JOIN professionals ON professionals.id = appointments.professional_id
            JOIN users ON users.id = professionals.user_id
            JOIN boxes ON boxes.id = appointments.box_id
            JOIN services ON services.id = appointments.service_id
            WHERE DATE(appointments.start_time) = :date
            ORDER BY appointments.start_time');
        $stmt->execute(['date' => $date]);
        $daily = $stmt->fetchAll();

        $noShowStmt = $db->prepare('SELECT COUNT(*) FROM appointments WHERE status = "no_asistio" AND start_time BETWEEN :start AND :end');
        $noShowStmt->execute([
            'start' => $date . ' 00:00:00',
            'end' => $date . ' 23:59:59',
        ]);
        $noShows = (int) $noShowStmt->fetchColumn();

        $occupancyStmt = $db->prepare('SELECT boxes.name, COUNT(appointments.id) AS total
            FROM boxes
            LEFT JOIN appointments ON appointments.box_id = boxes.id AND DATE(appointments.start_time) = :date
            GROUP BY boxes.id');
        $occupancyStmt->execute(['date' => $date]);
        $occupancy = $occupancyStmt->fetchAll();

        $newPatientsStmt = $db->prepare('SELECT COUNT(*) FROM patients WHERE DATE(created_at) = :date');
        $newPatientsStmt->execute(['date' => $date]);
        $newPatients = (int) $newPatientsStmt->fetchColumn();

        $this->view('reports/index', [
            'title' => 'Reportes',
            'date' => $date,
            'daily' => $daily,
            'noShows' => $noShows,
            'occupancy' => $occupancy,
            'newPatients' => $newPatients,
            'professionals' => (new Professional())->all(),
            'boxes' => (new Box())->all(),
        ]);
    }
}
