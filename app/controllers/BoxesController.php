<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Request;
use App\Core\Validator;
use App\Models\AuditLog;
use App\Models\Box;

class BoxesController extends Controller
{
    private function authorize(): void
    {
        if (!Auth::hasPermission('boxes.manage')) {
            http_response_code(403);
            $this->view('errors/403', ['title' => 'Sin permiso']);
            exit;
        }
    }

    public function index(): void
    {
        $this->authorize();
        $boxes = (new Box())->all();
        $this->view('boxes/index', ['title' => 'Box', 'boxes' => $boxes]);
    }

    public function create(): void
    {
        $this->authorize();
        $this->view('boxes/create', ['title' => 'Nuevo box']);
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
            'description' => Request::sanitize((string) Request::input('description')),
            'is_active' => Request::input('is_active') ? 1 : 0,
        ];
        $validator->required('name', $data['name'], 'Nombre requerido.');
        if ($validator->fails()) {
            $this->view('boxes/create', ['title' => 'Nuevo box', 'errors' => $validator->errors(), 'box' => $data]);
            return;
        }
        $id = (new Box())->create($data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'create', 'boxes', $id, []);
        $this->redirect('/boxes');
    }

    public function edit(string $id): void
    {
        $this->authorize();
        $box = (new Box())->find((int) $id);
        $this->view('boxes/edit', ['title' => 'Editar box', 'box' => $box]);
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
            'description' => Request::sanitize((string) Request::input('description')),
            'is_active' => Request::input('is_active') ? 1 : 0,
        ];
        $validator->required('name', $data['name'], 'Nombre requerido.');
        if ($validator->fails()) {
            $this->view('boxes/edit', ['title' => 'Editar box', 'errors' => $validator->errors(), 'box' => array_merge($data, ['id' => $id])]);
            return;
        }
        (new Box())->update((int) $id, $data);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'update', 'boxes', (int) $id, []);
        $this->redirect('/boxes');
    }

    public function delete(string $id): void
    {
        $this->authorize();
        if (!CSRF::validate(Request::input('csrf_token'))) {
            $this->redirect('/boxes');
            return;
        }
        (new Box())->delete((int) $id);
        (new AuditLog())->log($_SESSION['user_id'] ?? null, 'delete', 'boxes', (int) $id, []);
        $this->redirect('/boxes');
    }
}
