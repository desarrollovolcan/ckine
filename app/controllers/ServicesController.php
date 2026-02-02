<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\AuditLog;
use App\Models\Service;

class ServicesController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('services.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $services = (new Service())->all();
        $this->view('services/index', ['title' => 'Servicios', 'services' => $services]);
    }

    public function create(): void
    {
        $this->authorize();
        $this->view('services/create', ['title' => 'Nuevo servicio']);
    }

    public function store(): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
            'name' => Request::sanitize((string) Request::input('name')),
            'duration_minutes' => (int) Request::input('duration_minutes'),
            'price' => Request::input('price') !== '' ? (float) Request::input('price') : null,
            'description' => Request::sanitize((string) Request::input('description')),
        ];
        $validator->required('name', $data['name'], 'Nombre requerido.');
        if ($validator->fails()) {
            $this->view('services/create', ['title' => 'Nuevo servicio', 'errors' => $validator->errors(), 'service' => $data]);
            return;
        }
        $id = (new Service())->create($data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'services', $id, []);
        $this->redirect('/services');
    }

    public function edit(string $id): void
    {
        $this->authorize();
        $service = (new Service())->find((int) $id);
        $this->view('services/edit', ['title' => 'Editar servicio', 'service' => $service]);
    }

    public function update(string $id): void
    {
        $this->authorize();
        $validator = new Validator();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $validator->required('csrf', null, 'Token CSRF inválido.');
        }
        $data = [
            'name' => Request::sanitize((string) Request::input('name')),
            'duration_minutes' => (int) Request::input('duration_minutes'),
            'price' => Request::input('price') !== '' ? (float) Request::input('price') : null,
            'description' => Request::sanitize((string) Request::input('description')),
        ];
        $validator->required('name', $data['name'], 'Nombre requerido.');
        if ($validator->fails()) {
            $this->view('services/edit', ['title' => 'Editar servicio', 'errors' => $validator->errors(), 'service' => array_merge($data, ['id' => $id])]);
            return;
        }
        (new Service())->update((int) $id, $data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'update', 'services', (int) $id, []);
        $this->redirect('/services');
    }

    public function delete(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/services');
            return;
        }
        (new Service())->delete((int) $id);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'delete', 'services', (int) $id, []);
        $this->redirect('/services');
    }
}
