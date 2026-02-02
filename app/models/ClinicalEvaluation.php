<?php
namespace App\Models;

use App\Core\Model;

class ClinicalEvaluation extends Model
{
    public function findByPatient(int $patientId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM clinical_evaluations WHERE patient_id = :patient_id ORDER BY created_at DESC LIMIT 1');
        $stmt->execute(['patient_id' => $patientId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO clinical_evaluations (patient_id, appointment_id, reason, antecedentes, diagnosis, objectives, plan) VALUES (:patient_id, :appointment_id, :reason, :antecedentes, :diagnosis, :objectives, :plan)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }
}
