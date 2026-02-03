<?php

return [
    ['method' => 'GET', 'path' => '/', 'handler' => ['DashboardController', 'index'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/login', 'handler' => ['AuthPortalController', 'showLogin']],
    ['method' => 'POST', 'path' => '/login', 'handler' => ['AuthPortalController', 'login']],
    ['method' => 'POST', 'path' => '/logout', 'handler' => ['AuthPortalController', 'logout'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/password', 'handler' => ['AuthPortalController', 'changePassword'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/password', 'handler' => ['AuthPortalController', 'updatePassword'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/usuarios', 'handler' => ['UsersController', 'index'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'GET', 'path' => '/usuarios/nuevo', 'handler' => ['UsersController', 'create'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'POST', 'path' => '/usuarios', 'handler' => ['UsersController', 'store'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'GET', 'path' => '/usuarios/editar', 'handler' => ['UsersController', 'edit'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'POST', 'path' => '/usuarios/actualizar', 'handler' => ['UsersController', 'update'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'POST', 'path' => '/usuarios/eliminar', 'handler' => ['UsersController', 'delete'], 'middleware' => ['auth', 'role:Admin']],

    ['method' => 'GET', 'path' => '/roles', 'handler' => ['RolesController', 'index'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'GET', 'path' => '/roles/nuevo', 'handler' => ['RolesController', 'create'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'POST', 'path' => '/roles', 'handler' => ['RolesController', 'store'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'GET', 'path' => '/roles/editar', 'handler' => ['RolesController', 'edit'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'POST', 'path' => '/roles/actualizar', 'handler' => ['RolesController', 'update'], 'middleware' => ['auth', 'role:Admin']],
    ['method' => 'POST', 'path' => '/roles/eliminar', 'handler' => ['RolesController', 'delete'], 'middleware' => ['auth', 'role:Admin']],

    ['method' => 'GET', 'path' => '/pacientes', 'handler' => ['PatientsController', 'index'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/pacientes/nuevo', 'handler' => ['PatientsController', 'create'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/pacientes', 'handler' => ['PatientsController', 'store'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/pacientes/editar', 'handler' => ['PatientsController', 'edit'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/pacientes/actualizar', 'handler' => ['PatientsController', 'update'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/pacientes/ver', 'handler' => ['PatientsController', 'show'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/pacientes/eliminar', 'handler' => ['PatientsController', 'delete'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/profesionales', 'handler' => ['ProfessionalsController', 'index'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/profesionales/nuevo', 'handler' => ['ProfessionalsController', 'create'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/profesionales', 'handler' => ['ProfessionalsController', 'store'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/profesionales/editar', 'handler' => ['ProfessionalsController', 'edit'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/profesionales/actualizar', 'handler' => ['ProfessionalsController', 'update'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/profesionales/horarios', 'handler' => ['ProfessionalsController', 'schedule'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/profesionales/horarios', 'handler' => ['ProfessionalsController', 'storeSchedule'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/profesionales/eliminar', 'handler' => ['ProfessionalsController', 'delete'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/box', 'handler' => ['BoxesController', 'index'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/box/nuevo', 'handler' => ['BoxesController', 'create'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/box', 'handler' => ['BoxesController', 'store'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/box/editar', 'handler' => ['BoxesController', 'edit'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/box/actualizar', 'handler' => ['BoxesController', 'update'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/box/eliminar', 'handler' => ['BoxesController', 'delete'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/servicios', 'handler' => ['KineServicesController', 'index'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/servicios/nuevo', 'handler' => ['KineServicesController', 'create'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/servicios', 'handler' => ['KineServicesController', 'store'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/servicios/editar', 'handler' => ['KineServicesController', 'edit'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/servicios/actualizar', 'handler' => ['KineServicesController', 'update'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/servicios/eliminar', 'handler' => ['KineServicesController', 'delete'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/agenda', 'handler' => ['AppointmentsController', 'index'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/agenda/nueva', 'handler' => ['AppointmentsController', 'create'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/agenda', 'handler' => ['AppointmentsController', 'store'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/agenda/editar', 'handler' => ['AppointmentsController', 'edit'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/agenda/actualizar', 'handler' => ['AppointmentsController', 'update'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/agenda/estado', 'handler' => ['AppointmentsController', 'updateStatus'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/agenda/eliminar', 'handler' => ['AppointmentsController', 'delete'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/portal', 'handler' => ['PortalController', 'index']],
    ['method' => 'POST', 'path' => '/portal', 'handler' => ['PortalController', 'store']],

    ['method' => 'GET', 'path' => '/fichas', 'handler' => ['ClinicalController', 'index'], 'middleware' => ['auth']],
    ['method' => 'GET', 'path' => '/fichas/ver', 'handler' => ['ClinicalController', 'show'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/fichas/evaluacion', 'handler' => ['ClinicalController', 'storeEvaluation'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/fichas/evolucion', 'handler' => ['ClinicalController', 'storeEvolution'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/fichas/adjunto', 'handler' => ['ClinicalController', 'storeAttachment'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/reportes', 'handler' => ['ReportsController', 'index'], 'middleware' => ['auth']],
    ['method' => 'POST', 'path' => '/reportes', 'handler' => ['ReportsController', 'generate'], 'middleware' => ['auth']],

    ['method' => 'GET', 'path' => '/auditoria', 'handler' => ['AuditController', 'index'], 'middleware' => ['auth', 'role:Admin']],
];
