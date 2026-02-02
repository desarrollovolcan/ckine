<?php
namespace App\Models;

use App\Core\Model;

class ProfessionalSchedule extends Model
{
    public function allForProfessional(int $professionalId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM professional_schedules WHERE professional_id = :id ORDER BY weekday, start_time');
        $stmt->execute(['id' => $professionalId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO professional_schedules (professional_id, weekday, start_time, end_time, duration_minutes) VALUES (:professional_id, :weekday, :start_time, :end_time, :duration_minutes)');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM professional_schedules WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
