<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\AuditLog;
use App\Models\Patient;

class PatientsController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('patients.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $patients = (new Patient())->all();
        $this->view('patients/index', ['title' => 'Pacientes', 'patients' => $patients]);
    }

    public function create(): void
    {
        $this->authorize();
        $this->view('patients/create', ['title' => 'Nuevo paciente']);
    }

    public function store(): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
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
        $validator->required('first_name', $data['first_name'], 'Nombre requerido.');
        $validator->required('last_name', $data['last_name'], 'Apellido requerido.');
        $validator->required('rut', $data['rut'], 'RUT requerido.');
        $validator->rut('rut', $data['rut'], 'RUT inválido.');
        $validator->email('email', $data['email'], 'Email inválido.');

        if ($validator->fails()) {
            $this->view('patients/create', ['title' => 'Nuevo paciente', 'errors' => $validator->errors(), 'patient' => $data]);
            return;
        }

        $id = (new Patient())->create($data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'patients', $id, ['rut' => $data['rut']]);
        $this->redirect('/patients');
    }

    public function edit(string $id): void
    {
        $this->authorize();
        $patient = (new Patient())->find((int) $id);
        $this->view('patients/edit', ['title' => 'Editar paciente', 'patient' => $patient]);
    }

    public function update(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
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
        $validator->required('first_name', $data['first_name'], 'Nombre requerido.');
        $validator->required('last_name', $data['last_name'], 'Apellido requerido.');
        $validator->required('rut', $data['rut'], 'RUT requerido.');
        $validator->rut('rut', $data['rut'], 'RUT inválido.');
        $validator->email('email', $data['email'], 'Email inválido.');

        if ($validator->fails()) {
            $this->view('patients/edit', ['title' => 'Editar paciente', 'errors' => $validator->errors(), 'patient' => array_merge($data, ['id' => $id])]);
            return;
        }

        (new Patient())->update((int) $id, $data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'update', 'patients', (int) $id, ['rut' => $data['rut']]);
        $this->redirect('/patients');
    }

    public function delete(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/patients');
            return;
        }
        (new Patient())->delete((int) $id);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'delete', 'patients', (int) $id, []);
        $this->redirect('/patients');
    }
}
