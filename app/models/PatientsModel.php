<?php

class PatientsModel extends Model
{
    protected string $table = 'patients';

    public function active(int $companyId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE company_id = :company_id AND deleted_at IS NULL ORDER BY name ASC",
            ['company_id' => $companyId]
        );
    }

    public function findForCompany(int $id, int $companyId): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE id = :id AND company_id = :company_id AND deleted_at IS NULL",
            ['id' => $id, 'company_id' => $companyId]
        );
    }

    public function markDeleted(int $id, int $companyId): void
    {
        $this->db->execute(
            "UPDATE {$this->table} SET deleted_at = :deleted_at, updated_at = :updated_at WHERE id = :id AND company_id = :company_id",
            [
                'deleted_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'id' => $id,
                'company_id' => $companyId,
            ]
        );
    }
}
