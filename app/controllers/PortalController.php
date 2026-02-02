<?php
namespace App\Controllers;

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

class PortalController extends Controller
{
    public function index(): void
    {
        $app = require __DIR__ . '/../../config/app.php';
        if (!$app['public_portal_enabled']) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Portal deshabilitado']);
            return;
        }
        $this->view('portal/index', [
            'title' => 'Agendamiento',
            'patients' => (new Patient())->all(),
            'professionals' => (new Professional())->all(),
            'boxes' => (new Box())->all(),
            'services' => (new Service())->all(),
        ]);
    }

    public function store(): void
    {
        $app = require __DIR__ . '/../../config/app.php';
        if (!$app['public_portal_enabled']) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Portal deshabilitado']);
            return;
        }
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $patientData = [
            'first_name' => Request::sanitize((string) Request::input('first_name')),
            'last_name' => Request::sanitize((string) Request::input('last_name')),
            'rut' => Request::sanitize((string) Request::input('rut')),
            'birth_date' => Request::input('birth_date') ?: null,
            'phone' => Request::sanitize((string) Request::input('phone')),
            'email' => Request::sanitize((string) Request::input('email')),
            'address' => Request::sanitize((string) Request::input('address')),
            'insurance' => Request::sanitize((string) Request::input('insurance')),
            'emergency_contact' => Request::sanitize((string) Request::input('emergency_contact')),
            'notes' => Request::sanitize((string) Request::input('notes')),
        ];
        $validator->required('first_name', $patientData['first_name'], 'Nombre requerido.');
        $validator->required('last_name', $patientData['last_name'], 'Apellido requerido.');
        $validator->required('rut', $patientData['rut'], 'RUT requerido.');
        $validator->rut('rut', $patientData['rut'], 'RUT inválido.');

        $startTime = str_replace('T', ' ', (string) Request::input('start_time'));
        $endTime = str_replace('T', ' ', (string) Request::input('end_time'));
        $appointmentData = [
            'professional_id' => (int) Request::input('professional_id'),
            'box_id' => (int) Request::input('box_id'),
            'service_id' => (int) Request::input('service_id'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'notes' => Request::sanitize((string) Request::input('notes')),
        ];
        $validator->required('professional_id', (string) $appointmentData['professional_id'], 'Profesional requerido.');
        $validator->required('box_id', (string) $appointmentData['box_id'], 'Box requerido.');
        $validator->required('service_id', (string) $appointmentData['service_id'], 'Servicio requerido.');
        $validator->required('start_time', (string) $appointmentData['start_time'], 'Fecha/hora requerida.');
        $validator->required('end_time', (string) $appointmentData['end_time'], 'Hora término requerida.');

        $appointmentModel = new Appointment();
        if (!$validator->fails() && $appointmentModel->hasConflict($appointmentData['professional_id'], $appointmentData['box_id'], $appointmentData['start_time'], $appointmentData['end_time'])) {
            $validator->required('conflict', null, 'Existe un choque de horario, intenta otro horario.');
        }

        if ($validator->fails()) {
            $this->view('portal/index', [
                'title' => 'Agendamiento',
                'errors' => $validator->errors(),
                'patient' => $patientData,
                'appointment' => $appointmentData,
                'patients' => (new Patient())->all(),
                'professionals' => (new Professional())->all(),
                'boxes' => (new Box())->all(),
                'services' => (new Service())->all(),
            ]);
            return;
        }

        $patientModel = new Patient();
        $existing = $patientModel->findByRutOrEmail($patientData['rut'], $patientData['email']);
        $patientId = $existing ? (int) $existing['id'] : $patientModel->create($patientData);

        $appointmentId = $appointmentModel->create([
            'patient_id' => $patientId,
            'professional_id' => $appointmentData['professional_id'],
            'box_id' => $appointmentData['box_id'],
            'service_id' => $appointmentData['service_id'],
            'start_time' => $appointmentData['start_time'],
            'end_time' => $appointmentData['end_time'],
            'status' => 'pendiente',
            'notes' => $appointmentData['notes'],
            'created_by' => null,
        ]);

        (new AuditLog())->log(null, 'portal_create', 'appointments', $appointmentId, ['patient_id' => $patientId]);

        $this->view('portal/thanks', ['title' => 'Solicitud enviada']);
    }
}
