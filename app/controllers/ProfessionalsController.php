<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\AuditLog;
use App\Models\Professional;
use App\Models\ProfessionalSchedule;
use App\Models\User;

class ProfessionalsController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('professionals.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $professionals = (new Professional())->all();
        $this->view('professionals/index', ['title' => 'Profesionales', 'professionals' => $professionals]);
    }

    public function create(): void
    {
        $this->authorize();
        $users = (new User())->all();
        $this->view('professionals/create', ['title' => 'Nuevo profesional', 'users' => $users]);
    }

    public function store(): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
            'user_id' => (int) Request::input('user_id'),
            'title' => Request::sanitize((string) Request::input('title')),
            'license_number' => Request::sanitize((string) Request::input('license_number')),
            'phone' => Request::sanitize((string) Request::input('phone')),
            'email' => Request::sanitize((string) Request::input('email')),
        ];
        $validator->required('user_id', (string) $data['user_id'], 'Usuario requerido.');
        $validator->email('email', $data['email'], 'Email inválido.');
        if ($validator->fails()) {
            $users = (new User())->all();
            $this->view('professionals/create', ['title' => 'Nuevo profesional', 'users' => $users, 'errors' => $validator->errors(), 'professional' => $data]);
            return;
        }
        $id = (new Professional())->create($data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'professionals', $id, []);
        $this->redirect('/professionals');
    }

    public function edit(string $id): void
    {
        $this->authorize();
        $professional = (new Professional())->find((int) $id);
        $users = (new User())->all();
        $schedules = (new ProfessionalSchedule())->allForProfessional((int) $id);
        $this->view('professionals/edit', ['title' => 'Editar profesional', 'professional' => $professional, 'users' => $users, 'schedules' => $schedules]);
    }

    public function update(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
            'user_id' => (int) Request::input('user_id'),
            'title' => Request::sanitize((string) Request::input('title')),
            'license_number' => Request::sanitize((string) Request::input('license_number')),
            'phone' => Request::sanitize((string) Request::input('phone')),
            'email' => Request::sanitize((string) Request::input('email')),
        ];
        $validator->required('user_id', (string) $data['user_id'], 'Usuario requerido.');
        $validator->email('email', $data['email'], 'Email inválido.');
        if ($validator->fails()) {
            $users = (new User())->all();
            $schedules = (new ProfessionalSchedule())->allForProfessional((int) $id);
            $this->view('professionals/edit', ['title' => 'Editar profesional', 'professional' => array_merge($data, ['id' => $id]), 'users' => $users, 'schedules' => $schedules, 'errors' => $validator->errors()]);
            return;
        }
        (new Professional())->update((int) $id, $data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'update', 'professionals', (int) $id, []);
        $this->redirect('/professionals');
    }

    public function addSchedule(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/professionals/' . $id . '/edit');
            return;
        }
        $schedule = new ProfessionalSchedule();
        $schedule->create([
            'professional_id' => (int) $id,
            'weekday' => (int) Request::input('weekday'),
            'start_time' => Request::input('start_time'),
            'end_time' => Request::input('end_time'),
            'duration_minutes' => (int) Request::input('duration_minutes'),
        ]);
        $this->redirect('/professionals/' . $id . '/edit');
    }

    public function deleteSchedule(string $professionalId, string $scheduleId): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/professionals/' . $professionalId . '/edit');
            return;
        }
        (new ProfessionalSchedule())->delete((int) $scheduleId);
        $this->redirect('/professionals/' . $professionalId . '/edit');
    }

    public function delete(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/professionals');
            return;
        }
        (new Professional())->delete((int) $id);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'delete', 'professionals', (int) $id, []);
        $this->redirect('/professionals');
    }
}
