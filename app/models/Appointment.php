<?php
namespace App\Models;

use App\Core\Model;

class Appointment extends Model
{
    public function all(array $filters = []): array
    {
        $sql = 'SELECT appointments.*, patients.first_name, patients.last_name, professionals.id AS professional_id, users.name AS professional_name, boxes.name AS box_name, services.name AS service_name
                FROM appointments
                JOIN patients ON patients.id = appointments.patient_id
                JOIN professionals ON professionals.id = appointments.professional_id
                JOIN users ON users.id = professionals.user_id
                JOIN boxes ON boxes.id = appointments.box_id
                JOIN services ON services.id = appointments.service_id
                WHERE 1=1';
        $params = [];
        if (!empty($filters['date'])) {
            $sql .= ' AND DATE(start_time) = :date';
            $params['date'] = $filters['date'];
        }
        if (!empty($filters['professional_id'])) {
            $sql .= ' AND appointments.professional_id = :professional_id';
            $params['professional_id'] = $filters['professional_id'];
        }
        if (!empty($filters['box_id'])) {
            $sql .= ' AND appointments.box_id = :box_id';
            $params['box_id'] = $filters['box_id'];
        }
        if (!empty($filters['status'])) {
            $sql .= ' AND appointments.status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['patient_id'])) {
            $sql .= ' AND appointments.patient_id = :patient_id';
            $params['patient_id'] = $filters['patient_id'];
        }
        $sql .= ' ORDER BY start_time DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM appointments WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO appointments (patient_id, professional_id, box_id, service_id, start_time, end_time, status, notes, created_by) VALUES (:patient_id, :professional_id, :box_id, :service_id, :start_time, :end_time, :status, :notes, :created_by)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE appointments SET patient_id = :patient_id, professional_id = :professional_id, box_id = :box_id, service_id = :service_id, start_time = :start_time, end_time = :end_time, status = :status, notes = :notes, cancel_reason = :cancel_reason WHERE id = :id');
        $stmt->execute($data);
    }

    public function updateStatus(int $id, string $status, ?string $reason = null): void
    {
        $stmt = $this->db->prepare('UPDATE appointments SET status = :status, cancel_reason = :reason WHERE id = :id');
        $stmt->execute(['status' => $status, 'reason' => $reason, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM appointments WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function hasConflict(int $professionalId, int $boxId, string $startTime, string $endTime, ?int $ignoreId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM appointments
                WHERE id != :ignore_id
                AND status NOT IN ("cancelada")
                AND ((professional_id = :professional_id) OR (box_id = :box_id))
                AND (start_time < :end_time AND end_time > :start_time)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'ignore_id' => $ignoreId ?? 0,
            'professional_id' => $professionalId,
            'box_id' => $boxId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
