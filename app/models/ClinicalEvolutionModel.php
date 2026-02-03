<?php

declare(strict_types=1);

class ClinicalEvolutionModel extends Model
{
    protected string $table = 'patient_evolutions';

    public function forPatient(int $patientId): array
    {
        return $this->db->fetchAll('SELECT * FROM patient_evolutions WHERE patient_id = :patient_id ORDER BY created_at DESC', [
            'patient_id' => $patientId,
        ]);
    }
}
