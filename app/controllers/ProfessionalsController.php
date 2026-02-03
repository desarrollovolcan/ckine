<?php

declare(strict_types=1);

class ProfessionalsController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();
        $professionals = $this->db->fetchAll('SELECT * FROM professionals ORDER BY id DESC');
        $this->render('professionals/index', [
            'title' => 'Profesionales',
            'pageTitle' => 'Profesionales',
            'professionals' => $professionals,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        $users = (new UserModel($this->db))->allActive();
        $this->render('professionals/form', [
            'title' => 'Nuevo profesional',
            'pageTitle' => 'Nuevo profesional',
            'professional' => null,
            'users' => $users,
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();
        verify_csrf();

        $payload = $this->payload();
        if ($payload['first_name'] === '' || $payload['last_name'] === '') {
            flash('error', 'Nombre y apellido son obligatorios.');
            $this->redirect('/profesionales/nuevo');
        }

        $this->db->execute(
            'INSERT INTO professionals (user_id, first_name, last_name, specialty, phone, email, active, created_at, updated_at)
            VALUES (:user_id, :first_name, :last_name, :specialty, :phone, :email, :active, NOW(), NOW())',
            $payload
        );

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'professionals', (int)$this->db->lastInsertId(), $payload);
        flash('success', 'Profesional creado.');
        $this->redirect('/profesionales');
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $professional = $this->db->fetch('SELECT * FROM professionals WHERE id = :id', ['id' => $id]);
        if (!$professional) {
            $this->redirect('/profesionales');
        }
        $users = (new UserModel($this->db))->allActive();
        $this->render('professionals/form', [
            'title' => 'Editar profesional',
            'pageTitle' => 'Editar profesional',
            'professional' => $professional,
            'users' => $users,
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $payload = $this->payload();
        $payload['id'] = $id;

        $this->db->execute(
            'UPDATE professionals SET user_id = :user_id, first_name = :first_name, last_name = :last_name, specialty = :specialty, phone = :phone, email = :email, active = :active, updated_at = NOW() WHERE id = :id',
            $payload
        );

        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'update', 'professionals', $id, $payload);
        flash('success', 'Profesional actualizado.');
        $this->redirect('/profesionales');
    }

    public function schedule(): void
    {
        $this->requireLogin();
        $professionalId = (int)($_GET['id'] ?? 0);
        $professional = $this->db->fetch('SELECT * FROM professionals WHERE id = :id', ['id' => $professionalId]);
        if (!$professional) {
            $this->redirect('/profesionales');
        }
        $schedules = $this->db->fetchAll('SELECT * FROM professional_schedules WHERE professional_id = :professional_id ORDER BY day_of_week, start_time', [
            'professional_id' => $professionalId,
        ]);
        $this->render('professionals/schedule', [
            'title' => 'Horarios',
            'pageTitle' => 'Horarios de profesional',
            'professional' => $professional,
            'schedules' => $schedules,
        ]);
    }

    public function storeSchedule(): void
    {
        $this->requireLogin();
        verify_csrf();
        $professionalId = (int)($_POST['professional_id'] ?? 0);
        $day = (int)($_POST['day_of_week'] ?? 0);
        $start = $_POST['start_time'] ?? '';
        $end = $_POST['end_time'] ?? '';
        $slot = (int)($_POST['slot_minutes'] ?? 60);

        if ($professionalId === 0 || $start === '' || $end === '') {
            flash('error', 'Completa los campos del horario.');
            $this->redirect('/profesionales/horarios?id=' . $professionalId);
        }

        $this->db->execute(
            'INSERT INTO professional_schedules (professional_id, day_of_week, start_time, end_time, slot_minutes) VALUES (:professional_id, :day_of_week, :start_time, :end_time, :slot_minutes)',
            [
                'professional_id' => $professionalId,
                'day_of_week' => $day,
                'start_time' => $start,
                'end_time' => $end,
                'slot_minutes' => $slot,
            ]
        );
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'create', 'professional_schedules', (int)$this->db->lastInsertId(), ['professional_id' => $professionalId]);
        flash('success', 'Horario agregado.');
        $this->redirect('/profesionales/horarios?id=' . $professionalId);
    }

    public function delete(): void
    {
        $this->requireLogin();
        verify_csrf();

        $id = (int)($_POST['id'] ?? 0);
        $this->db->execute('DELETE FROM professionals WHERE id = :id', ['id' => $id]);
        audit_log_kine($this->db, (int)(Auth::user()['id'] ?? 0), 'delete', 'professionals', $id);
        flash('success', 'Profesional eliminado.');
        $this->redirect('/profesionales');
    }

    private function payload(): array
    {
        return [
            'user_id' => ($_POST['user_id'] ?? '') !== '' ? (int)$_POST['user_id'] : null,
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'specialty' => trim($_POST['specialty'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'active' => isset($_POST['active']) ? 1 : 0,
        ];
    }
}
