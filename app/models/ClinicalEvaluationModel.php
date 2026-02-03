<?php

declare(strict_types=1);

class ClinicalEvaluationModel extends Model
{
    protected string $table = 'patient_evaluations';

    public function latestByPatient(int $patientId): ?array
    {
        return $this->db->fetch('SELECT * FROM patient_evaluations WHERE patient_id = :patient_id ORDER BY created_at DESC LIMIT 1', [
            'patient_id' => $patientId,
        ]);
    }
}
