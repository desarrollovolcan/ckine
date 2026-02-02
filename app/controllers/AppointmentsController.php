<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\Appointment;
use App\Models\AuditLog;
use App\Models\Box;
use App\Models\Patient;
use App\Models\Professional;
use App\Models\Service;

class AppointmentsController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('appointments.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $filters = [
            'date' => Request::input('date'),
            'professional_id' => Request::input('professional_id'),
            'box_id' => Request::input('box_id'),
            'status' => Request::input('status'),
        ];
        $appointments = (new Appointment())->all($filters);
        $this->view('appointments/index', [
            'title' => 'Agenda',
            'appointments' => $appointments,
            'filters' => $filters,
            'professionals' => (new Professional())->all(),
            'boxes' => (new Box())->all(),
        ]);
    }

    public function create(): void
    {
        $this->authorize();
        $this->view('appointments/create', [
            'title' => 'Nueva cita',
            'patients' => (new Patient())->all(),
            'professionals' => (new Professional())->all(),
            'boxes' => (new Box())->all(),
            'services' => (new Service())->all(),
        ]);
    }

    public function store(): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $startTime = str_replace('T', ' ', (string) Request::input('start_time'));
        $endTime = str_replace('T', ' ', (string) Request::input('end_time'));
        $data = [
            'patient_id' => (int) Request::input('patient_id'),
            'professional_id' => (int) Request::input('professional_id'),
            'box_id' => (int) Request::input('box_id'),
            'service_id' => (int) Request::input('service_id'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => Request::sanitize((string) Request::input('status')),
            'notes' => Request::sanitize((string) Request::input('notes')),
            'created_by' => $_SESSION['user_id'] ?? null,
        ];
        $validator->required('patient_id', (string) $data['patient_id'], 'Paciente requerido.');
        $validator->required('professional_id', (string) $data['professional_id'], 'Profesional requerido.');
        $validator->required('box_id', (string) $data['box_id'], 'Box requerido.');
        $validator->required('service_id', (string) $data['service_id'], 'Servicio requerido.');
        $validator->required('start_time', (string) $data['start_time'], 'Fecha/hora requerida.');
        $validator->required('end_time', (string) $data['end_time'], 'Hora término requerida.');

        $appointmentModel = new Appointment();
        if (!$validator->fails() && $appointmentModel->hasConflict($data['professional_id'], $data['box_id'], $data['start_time'], $data['end_time'])) {
            $validator->required('conflict', null, 'Existe un choque de horario en profesional o box.');
        }

        if ($validator->fails()) {
            $this->view('appointments/create', [
                'title' => 'Nueva cita',
                'errors' => $validator->errors(),
                'appointment' => $data,
                'patients' => (new Patient())->all(),
                'professionals' => (new Professional())->all(),
                'boxes' => (new Box())->all(),
                'services' => (new Service())->all(),
            ]);
            return;
        }
        $id = $appointmentModel->create($data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'appointments', $id, ['status' => $data['status']]);
        $this->redirect('/appointments');
    }

    public function edit(string $id): void
    {
        $this->authorize();
        $appointment = (new Appointment())->find((int) $id);
        $this->view('appointments/edit', [
            'title' => 'Editar cita',
            'appointment' => $appointment,
            'patients' => (new Patient())->all(),
            'professionals' => (new Professional())->all(),
            'boxes' => (new Box())->all(),
            'services' => (new Service())->all(),
        ]);
    }

    public function update(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $startTime = str_replace('T', ' ', (string) Request::input('start_time'));
        $endTime = str_replace('T', ' ', (string) Request::input('end_time'));
        $data = [
            'patient_id' => (int) Request::input('patient_id'),
            'professional_id' => (int) Request::input('professional_id'),
            'box_id' => (int) Request::input('box_id'),
            'service_id' => (int) Request::input('service_id'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => Request::sanitize((string) Request::input('status')),
            'notes' => Request::sanitize((string) Request::input('notes')),
            'cancel_reason' => Request::sanitize((string) Request::input('cancel_reason')),
        ];
        $validator->required('patient_id', (string) $data['patient_id'], 'Paciente requerido.');
        $validator->required('professional_id', (string) $data['professional_id'], 'Profesional requerido.');
        $validator->required('box_id', (string) $data['box_id'], 'Box requerido.');
        $validator->required('service_id', (string) $data['service_id'], 'Servicio requerido.');
        $validator->required('start_time', (string) $data['start_time'], 'Fecha/hora requerida.');
        $validator->required('end_time', (string) $data['end_time'], 'Hora término requerida.');
        $appointmentModel = new Appointment();
        if (!$validator->fails() && $appointmentModel->hasConflict($data['professional_id'], $data['box_id'], $data['start_time'], $data['end_time'], (int) $id)) {
            $validator->required('conflict', null, 'Existe un choque de horario en profesional o box.');
        }
        if ($validator->fails()) {
            $this->view('appointments/edit', [
                'title' => 'Editar cita',
                'errors' => $validator->errors(),
                'appointment' => array_merge($data, ['id' => $id]),
                'patients' => (new Patient())->all(),
                'professionals' => (new Professional())->all(),
                'boxes' => (new Box())->all(),
                'services' => (new Service())->all(),
            ]);
            return;
        }
        $appointmentModel->update((int) $id, $data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'update', 'appointments', (int) $id, ['status' => $data['status']]);
        $this->redirect('/appointments');
    }

    public function status(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/appointments');
            return;
        }
        $status = Request::sanitize((string) Request::input('status'));
        $reason = Request::sanitize((string) Request::input('cancel_reason'));
        (new Appointment())->updateStatus((int) $id, $status, $reason ?: null);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'status', 'appointments', (int) $id, ['status' => $status]);
        $this->redirect('/appointments');
    }

    public function delete(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/appointments');
            return;
        }
        (new Appointment())->delete((int) $id);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'delete', 'appointments', (int) $id, []);
        $this->redirect('/appointments');
    }
}
