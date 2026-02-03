<?php

class ClinicalNotesModel extends Model
{
    protected string $table = 'clinical_notes';

    public function byPatient(int $companyId, int $patientId): array
    {
        return $this->db->fetchAll(
            'SELECT clinical_notes.*,
                    professionals.name AS professional_name
             FROM clinical_notes
             LEFT JOIN professionals ON clinical_notes.professional_id = professionals.id
             WHERE clinical_notes.deleted_at IS NULL
               AND clinical_notes.company_id = :company_id
               AND clinical_notes.patient_id = :patient_id
             ORDER BY clinical_notes.note_date DESC, clinical_notes.id DESC',
            ['company_id' => $companyId, 'patient_id' => $patientId]
        );
    }
}
