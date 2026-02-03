<?php

class ClinicalNotesModel extends Model
{
    protected string $table = 'clinical_notes';

    public function forPatient(int $companyId, int $patientId): array
    {
        return $this->db->fetchAll(
            "SELECT clinical_notes.*, users.name AS professional_name
            FROM {$this->table}
            LEFT JOIN users ON users.id = clinical_notes.created_by
            WHERE clinical_notes.company_id = :company_id
                AND clinical_notes.patient_id = :patient_id
                AND clinical_notes.deleted_at IS NULL
            ORDER BY clinical_notes.note_date DESC, clinical_notes.id DESC",
            ['company_id' => $companyId, 'patient_id' => $patientId]
        );
    }

    public function latestByCompany(int $companyId): array
    {
        return $this->db->fetchAll(
            "SELECT clinical_notes.*, users.name AS professional_name
            FROM {$this->table}
            LEFT JOIN users ON users.id = clinical_notes.created_by
            WHERE clinical_notes.company_id = :company_id
                AND clinical_notes.deleted_at IS NULL
            ORDER BY clinical_notes.note_date DESC, clinical_notes.id DESC",
            ['company_id' => $companyId]
        );
    }
}
