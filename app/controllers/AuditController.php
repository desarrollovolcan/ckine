<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\AuditLog;

class AuditController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('audit.view')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $logs = (new AuditLog())->all();
        $this->view('audit/index', ['title' => 'Auditoría', 'logs' => $logs]);
    }
}
