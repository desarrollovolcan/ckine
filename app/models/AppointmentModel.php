<?php

declare(strict_types=1);

class AppointmentModel extends Model
{
    protected string $table = 'appointments';

    public function allWithRelations(array $filters = []): array
    {
        $where = '1=1';
        $params = [];
        if (!empty($filters['date'])) {
            $where .= ' AND DATE(a.start_at) = :date';
            $params['date'] = $filters['date'];
        }
        if (!empty($filters['status'])) {
            $where .= ' AND a.status = :status';
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['professional_id'])) {
            $where .= ' AND a.professional_id = :professional_id';
            $params['professional_id'] = $filters['professional_id'];
        }
        if (!empty($filters['box_id'])) {
            $where .= ' AND a.box_id = :box_id';
            $params['box_id'] = $filters['box_id'];
        }
        if (!empty($filters['patient_id'])) {
            $where .= ' AND a.patient_id = :patient_id';
            $params['patient_id'] = $filters['patient_id'];
        }

        $sql = "SELECT a.*, p.first_name, p.last_name,
                pr.first_name AS prof_name, pr.last_name AS prof_last,
                b.name AS box_name, s.name AS service_name
                FROM appointments a
                INNER JOIN patients p ON p.id = a.patient_id
                INNER JOIN professionals pr ON pr.id = a.professional_id
                INNER JOIN boxes b ON b.id = a.box_id
                INNER JOIN services s ON s.id = a.service_id
                WHERE {$where}
                ORDER BY a.start_at ASC";
        return $this->db->fetchAll($sql, $params);
    }

    public function hasConflict(int $professionalId, int $boxId, string $startAt, string $endAt, ?int $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) AS total FROM appointments
                WHERE status NOT IN ("cancelada")
                  AND (professional_id = :professional_id OR box_id = :box_id)
                  AND start_at < :end_at AND end_at > :start_at';
        $params = [
            'professional_id' => $professionalId,
            'box_id' => $boxId,
            'start_at' => $startAt,
            'end_at' => $endAt,
        ];
        if ($excludeId) {
            $sql .= ' AND id <> :exclude_id';
            $params['exclude_id'] = $excludeId;
        }
        $row = $this->db->fetch($sql, $params);
        return (int)($row['total'] ?? 0) > 0;
    }
}
