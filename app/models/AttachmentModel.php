<?php

declare(strict_types=1);

class AttachmentModel extends Model
{
    protected string $table = 'attachments';

    public function forPatient(int $patientId): array
    {
        return $this->db->fetchAll('SELECT * FROM attachments WHERE patient_id = :patient_id ORDER BY created_at DESC', [
            'patient_id' => $patientId,
        ]);
    }
}
