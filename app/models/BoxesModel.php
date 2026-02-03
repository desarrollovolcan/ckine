<?php

class BoxesModel extends Model
{
    protected string $table = 'boxes';

    public function active(int $companyId): array
    {
        return $this->db->fetchAll(
            'SELECT * FROM boxes WHERE deleted_at IS NULL AND company_id = :company_id ORDER BY id DESC',
            ['company_id' => $companyId]
        );
    }

    public function findByCompany(int $companyId, int $id): ?array
    {
        return $this->db->fetch(
            'SELECT * FROM boxes WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL',
            ['id' => $id, 'company_id' => $companyId]
        );
    }
}
