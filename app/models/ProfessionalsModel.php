<?php

class ProfessionalsModel extends Model
{
    protected string $table = 'professionals';

    public function active(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM professionals WHERE deleted_at IS NULL AND company_id = :company_id ORDER BY id DESC',
            ['company_id' => $companyId]
        );
    }

    public function findByCompany(int $companyId, int $id): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM professionals WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL',
            ['id' => $id, 'company_id' => $companyId]
        );
    }
}
