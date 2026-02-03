<?php

class ProfessionalsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $professionals = [
            ['id' => 201, 'name' => 'Dra. Paula Fuentes', 'specialty' => 'Kinesiología deportiva', 'email' => 'paula.fuentes@example.com', 'phone' => '+56 9 2222 3344', 'status' => 'Activo'],
            ['id' => 202, 'name' => 'Sr. Diego Valdés', 'specialty' => 'Rehabilitación neurológica', 'email' => 'diego.valdes@example.com', 'phone' => '+56 9 3333 4455', 'status' => 'Activo'],
            ['id' => 203, 'name' => 'Lic. Fernanda Rojas', 'specialty' => 'Kinesiología respiratoria', 'email' => 'fernanda.rojas@example.com', 'phone' => '+56 9 4444 5566', 'status' => 'En pausa'],
        ];
        $this->render('professionals/index', [
            'title' => 'Profesionales',
            'subtitle' => 'Clínica',
            'professionals' => $professionals,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $this->render('professionals/create', [
            'title' => 'Nuevo profesional',
            'subtitle' => 'Profesionales',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $rut = normalize_rut($_POST['rut'] ?? '');
        $specialty = trim($_POST['specialty'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $licenseNumber = trim($_POST['license_number'] ?? '');
        $schedule = trim($_POST['schedule'] ?? '');
        $modality = trim($_POST['modality'] ?? '');
        $status = trim($_POST['status'] ?? 'Activo');
        $allowedModalities = ['Presencial', 'Mixta', 'Telemedicina'];
        $allowedStatuses = ['Activo', 'En pausa'];

        if (!Validator::required($name) || !Validator::required($rut) || !Validator::required($specialty) || !Validator::required($email)) {
            flash('error', 'Completa los campos obligatorios para registrar al profesional.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!Validator::rut($rut)) {
            flash('error', 'El RUT ingresado no es válido.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!Validator::email($email)) {
            flash('error', 'El correo ingresado no es válido.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!Validator::required($phone) || !Validator::required($licenseNumber) || !Validator::required($schedule) || !Validator::required($modality)) {
            flash('error', 'Completa teléfono, registro profesional, modalidad y horario.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!in_array($modality, $allowedModalities, true)) {
            flash('error', 'Selecciona una modalidad válida.');
            $this->redirect('index.php?route=professionals/create');
        }
        if (!in_array($status, $allowedStatuses, true)) {
            flash('error', 'Selecciona un estado válido.');
            $this->redirect('index.php?route=professionals/create');
        }
        flash('success', 'Profesional creado correctamente (demo).');
        $this->redirect('index.php?route=professionals');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $professionalId = (int)($_GET['id'] ?? 0);
        $this->render('professionals/edit', [
            'title' => 'Editar profesional',
            'subtitle' => 'Profesionales',
            'professionalId' => $professionalId,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();
        $professionalId = (int)($_GET['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $rut = normalize_rut($_POST['rut'] ?? '');
        $specialty = trim($_POST['specialty'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $licenseNumber = trim($_POST['license_number'] ?? '');
        $schedule = trim($_POST['schedule'] ?? '');
        $modality = trim($_POST['modality'] ?? '');
        $status = trim($_POST['status'] ?? 'Activo');
        $allowedModalities = ['Presencial', 'Mixta', 'Telemedicina'];
        $allowedStatuses = ['Activo', 'En pausa'];

        if (!Validator::required($name) || !Validator::required($rut) || !Validator::required($specialty) || !Validator::required($email)) {
            flash('error', 'Completa los campos obligatorios para actualizar al profesional.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!Validator::rut($rut)) {
            flash('error', 'El RUT ingresado no es válido.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!Validator::email($email)) {
            flash('error', 'El correo ingresado no es válido.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!Validator::required($phone) || !Validator::required($licenseNumber) || !Validator::required($schedule) || !Validator::required($modality)) {
            flash('error', 'Completa teléfono, registro profesional, modalidad y horario.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!in_array($modality, $allowedModalities, true)) {
            flash('error', 'Selecciona una modalidad válida.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        if (!in_array($status, $allowedStatuses, true)) {
            flash('error', 'Selecciona un estado válido.');
            $this->redirect('index.php?route=professionals/edit&id=' . $professionalId);
        }
        flash('success', 'Profesional actualizado correctamente (demo).');
        $this->redirect('index.php?route=professionals');
    }

    public function show(): void
    {
        $this->requireLogin();
        $professionalId = (int)($_GET['id'] ?? 0);
        $this->render('professionals/show', [
            'title' => 'Perfil profesional',
            'subtitle' => 'Profesionales',
            'professionalId' => $professionalId,
        ]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();
        $professionalId = (int)($_POST['id'] ?? 0);
        flash('success', "Profesional {$professionalId} eliminado correctamente (demo).");
        $this->redirect('index.php?route=professionals');
    }
}
