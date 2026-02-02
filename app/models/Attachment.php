<?php
namespace App\Models;

use App\Core\Model;

class Attachment extends Model
{
    public function allForPatient(int $patientId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM attachments WHERE patient_id = :patient_id ORDER BY created_at DESC');
        $stmt->execute(['patient_id' => $patientId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO attachments (patient_id, appointment_id, file_path, file_name, file_type, uploaded_by) VALUES (:patient_id, :appointment_id, :file_path, :file_name, :file_type, :uploaded_by)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }
}
