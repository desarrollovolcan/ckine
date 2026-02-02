<?php
namespace App\Models;

use App\Core\Model;

class ClinicalEvolution extends Model
{
    public function allForPatient(int $patientId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM clinical_evolutions WHERE patient_id = :patient_id ORDER BY created_at DESC');
        $stmt->execute(['patient_id' => $patientId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO clinical_evolutions (patient_id, appointment_id, notes, procedures, exercises) VALUES (:patient_id, :appointment_id, :notes, :procedures, :exercises)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }
}
