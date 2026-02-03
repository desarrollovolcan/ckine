<?php

class PatientsModel extends Model
{
    protected string $table = 'patients';

    public function active(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM patients WHERE deleted_at IS NULL AND company_id = :company_id ORDER BY id DESC',
            ['company_id' => $companyId]
        );
    }

    public function findByCompany(int $companyId, int $id): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM patients WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL',
            ['id' => $id, 'company_id' => $companyId]
        );
    }
}
