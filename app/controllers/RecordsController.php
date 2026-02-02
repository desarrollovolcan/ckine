<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\Appointment;
use App\Models\Attachment;
use App\Models\AuditLog;
use App\Models\ClinicalEvaluation;
use App\Models\ClinicalEvolution;
use App\Models\Patient;

class RecordsController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('records.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $patients = (new Patient())->all();
        $this->view('records/index', ['title' => 'Ficha clínica', 'patients' => $patients]);
    }

    public function show(string $id): void
    {
        $this->authorize();
        $patient = (new Patient())->find((int) $id);
        $evaluation = (new ClinicalEvaluation())->findByPatient((int) $id);
        $evolutions = (new ClinicalEvolution())->allForPatient((int) $id);
        $attachments = (new Attachment())->allForPatient((int) $id);
        $appointments = (new Appointment())->all(['patient_id' => $id]);
        $this->view('records/show', [
            'title' => 'Ficha clínica',
            'patient' => $patient,
            'evaluation' => $evaluation,
            'evolutions' => $evolutions,
            'attachments' => $attachments,
            'appointments' => $appointments,
        ]);
    }

    public function storeEvaluation(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
            'patient_id' => (int) $id,
            'appointment_id' => Request::input('appointment_id') ?: null,
            'reason' => Request::sanitize((string) Request::input('reason')),
            'antecedentes' => Request::sanitize((string) Request::input('antecedentes')),
            'diagnosis' => Request::sanitize((string) Request::input('diagnosis')),
            'objectives' => Request::sanitize((string) Request::input('objectives')),
            'plan' => Request::sanitize((string) Request::input('plan')),
        ];
        $validator->required('reason', $data['reason'], 'Motivo requerido.');
        if ($validator->fails()) {
            $this->redirect('/records/' . $id);
            return;
        }
        (new ClinicalEvaluation())->create($data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'clinical_evaluations', null, ['patient_id' => $id]);
        $this->redirect('/records/' . $id);
    }

    public function storeEvolution(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
            'patient_id' => (int) $id,
            'appointment_id' => Request::input('appointment_id') ?: null,
            'notes' => Request::sanitize((string) Request::input('notes')),
            'procedures' => Request::sanitize((string) Request::input('procedures')),
            'exercises' => Request::sanitize((string) Request::input('exercises')),
        ];
        $validator->required('notes', $data['notes'], 'Notas requeridas.');
        if ($validator->fails()) {
            $this->redirect('/records/' . $id);
            return;
        }
        (new ClinicalEvolution())->create($data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'clinical_evolutions', null, ['patient_id' => $id]);
        $this->redirect('/records/' . $id);
    }

    public function uploadAttachment(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/records/' . $id);
            return;
        }
        if (empty($_FILES['attachment']['name'])) {
            $this->redirect('/records/' . $id);
            return;
        }
        $uploadDir = __DIR__ . '/../../storage/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        $original = basename($_FILES['attachment']['name']);
        $ext = pathinfo($original, PATHINFO_EXTENSION);
        $filename = uniqid('file_', true) . '.' . $ext;
        $target = $uploadDir . '/' . $filename;
        if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $target)) {
            $this->redirect('/records/' . $id);
            return;
        }
        $relativePath = '/storage/uploads/' . $filename;
        (new Attachment())->create([
            'patient_id' => (int) $id,
            'appointment_id' => Request::input('appointment_id') ?: null,
            'file_path' => $relativePath,
            'file_name' => $original,
            'file_type' => $_FILES['attachment']['type'] ?? null,
            'uploaded_by' => $_SESSION['user_id'] ?? null,
        ]);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'attachments', null, ['patient_id' => $id]);
        $this->redirect('/records/' . $id);
    }
}
