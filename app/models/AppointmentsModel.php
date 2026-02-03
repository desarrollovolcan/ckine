<?php

class AppointmentsModel extends Model
{
    protected string $table = 'appointments';

    public function activeByCompany(int $companyId): array
    {
        $sql = "SELECT a.*, p.name AS patient_name, pr.name AS professional_name, b.name AS box_name
                FROM {$this->table} a
                INNER JOIN patients p ON p.id = a.patient_id AND p.company_id = a.company_id AND p.deleted_at IS NULL
                INNER JOIN professionals pr ON pr.id = a.professional_id AND pr.company_id = a.company_id AND pr.deleted_at IS NULL
                LEFT JOIN boxes b ON b.id = a.box_id AND b.company_id = a.company_id AND b.deleted_at IS NULL
                WHERE a.company_id = :company_id AND a.deleted_at IS NULL
                ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        return $this->db->fetchAll($sql, ['company_id' => $companyId]);
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
