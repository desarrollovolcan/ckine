<?php

declare(strict_types=1);

class PatientModel extends Model
{
    protected string $table = 'patients';

    public function allActive(): array
    {
        return $this->db->fetchAll('SELECT * FROM patients WHERE deleted_at IS NULL ORDER BY id DESC');
    }
}
