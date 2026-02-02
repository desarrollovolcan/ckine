<?php

use App\Controllers\AppointmentsController;
use App\Controllers\AuditController;
use App\Controllers\AuthController;
use App\Controllers\BoxesController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\PatientsController;
use App\Controllers\PortalController;
use App\Controllers\ProfessionalsController;
use App\Controllers\RecordsController;
use App\Controllers\ReportsController;
use App\Controllers\RolesController;
use App\Controllers\ServicesController;
use App\Controllers\UsersController;
use App\Middlewares\AuthMiddleware;

$router->get('', [HomeController::class, 'index']);
$router->get('dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$router->get('auth/login', [AuthController::class, 'showLogin']);
$router->post('auth/login', [AuthController::class, 'login']);
$router->get('auth/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);
$router->get('auth/password', [AuthController::class, 'showChangePassword'], [AuthMiddleware::class]);
$router->post('auth/password', [AuthController::class, 'changePassword'], [AuthMiddleware::class]);

$router->get('users', [UsersController::class, 'index'], [AuthMiddleware::class]);
$router->get('users/create', [UsersController::class, 'create'], [AuthMiddleware::class]);
$router->post('users', [UsersController::class, 'store'], [AuthMiddleware::class]);
$router->get('users/{id}/edit', [UsersController::class, 'edit'], [AuthMiddleware::class]);
$router->post('users/{id}/update', [UsersController::class, 'update'], [AuthMiddleware::class]);
$router->post('users/{id}/delete', [UsersController::class, 'delete'], [AuthMiddleware::class]);

$router->get('roles', [RolesController::class, 'index'], [AuthMiddleware::class]);
$router->get('roles/create', [RolesController::class, 'create'], [AuthMiddleware::class]);
$router->post('roles', [RolesController::class, 'store'], [AuthMiddleware::class]);
$router->get('roles/{id}/edit', [RolesController::class, 'edit'], [AuthMiddleware::class]);
$router->post('roles/{id}/update', [RolesController::class, 'update'], [AuthMiddleware::class]);
$router->post('roles/{id}/delete', [RolesController::class, 'delete'], [AuthMiddleware::class]);

$router->get('patients', [PatientsController::class, 'index'], [AuthMiddleware::class]);
$router->get('patients/create', [PatientsController::class, 'create'], [AuthMiddleware::class]);
$router->post('patients', [PatientsController::class, 'store'], [AuthMiddleware::class]);
$router->get('patients/{id}/edit', [PatientsController::class, 'edit'], [AuthMiddleware::class]);
$router->post('patients/{id}/update', [PatientsController::class, 'update'], [AuthMiddleware::class]);
$router->post('patients/{id}/delete', [PatientsController::class, 'delete'], [AuthMiddleware::class]);

$router->get('professionals', [ProfessionalsController::class, 'index'], [AuthMiddleware::class]);
$router->get('professionals/create', [ProfessionalsController::class, 'create'], [AuthMiddleware::class]);
$router->post('professionals', [ProfessionalsController::class, 'store'], [AuthMiddleware::class]);
$router->get('professionals/{id}/edit', [ProfessionalsController::class, 'edit'], [AuthMiddleware::class]);
$router->post('professionals/{id}/update', [ProfessionalsController::class, 'update'], [AuthMiddleware::class]);
$router->post('professionals/{id}/schedules', [ProfessionalsController::class, 'addSchedule'], [AuthMiddleware::class]);
$router->post('professionals/{id}/schedules/{scheduleId}/delete', [ProfessionalsController::class, 'deleteSchedule'], [AuthMiddleware::class]);
$router->post('professionals/{id}/delete', [ProfessionalsController::class, 'delete'], [AuthMiddleware::class]);

$router->get('boxes', [BoxesController::class, 'index'], [AuthMiddleware::class]);
$router->get('boxes/create', [BoxesController::class, 'create'], [AuthMiddleware::class]);
$router->post('boxes', [BoxesController::class, 'store'], [AuthMiddleware::class]);
$router->get('boxes/{id}/edit', [BoxesController::class, 'edit'], [AuthMiddleware::class]);
$router->post('boxes/{id}/update', [BoxesController::class, 'update'], [AuthMiddleware::class]);
$router->post('boxes/{id}/delete', [BoxesController::class, 'delete'], [AuthMiddleware::class]);

$router->get('services', [ServicesController::class, 'index'], [AuthMiddleware::class]);
$router->get('services/create', [ServicesController::class, 'create'], [AuthMiddleware::class]);
$router->post('services', [ServicesController::class, 'store'], [AuthMiddleware::class]);
$router->get('services/{id}/edit', [ServicesController::class, 'edit'], [AuthMiddleware::class]);
$router->post('services/{id}/update', [ServicesController::class, 'update'], [AuthMiddleware::class]);
$router->post('services/{id}/delete', [ServicesController::class, 'delete'], [AuthMiddleware::class]);

$router->get('appointments', [AppointmentsController::class, 'index'], [AuthMiddleware::class]);
$router->get('appointments/create', [AppointmentsController::class, 'create'], [AuthMiddleware::class]);
$router->post('appointments', [AppointmentsController::class, 'store'], [AuthMiddleware::class]);
$router->get('appointments/{id}/edit', [AppointmentsController::class, 'edit'], [AuthMiddleware::class]);
$router->post('appointments/{id}/update', [AppointmentsController::class, 'update'], [AuthMiddleware::class]);
$router->post('appointments/{id}/status', [AppointmentsController::class, 'status'], [AuthMiddleware::class]);
$router->post('appointments/{id}/delete', [AppointmentsController::class, 'delete'], [AuthMiddleware::class]);

$router->get('portal', [PortalController::class, 'index']);
$router->post('portal', [PortalController::class, 'store']);

$router->get('records', [RecordsController::class, 'index'], [AuthMiddleware::class]);
$router->get('records/{id}', [RecordsController::class, 'show'], [AuthMiddleware::class]);
$router->post('records/{id}/evaluation', [RecordsController::class, 'storeEvaluation'], [AuthMiddleware::class]);
$router->post('records/{id}/evolutions', [RecordsController::class, 'storeEvolution'], [AuthMiddleware::class]);
$router->post('records/{id}/attachments', [RecordsController::class, 'uploadAttachment'], [AuthMiddleware::class]);

$router->get('reports', [ReportsController::class, 'index'], [AuthMiddleware::class]);

$router->get('audit', [AuditController::class, 'index'], [AuthMiddleware::class]);
