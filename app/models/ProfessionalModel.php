<?php

declare(strict_types=1);

class ProfessionalModel extends Model
{
    protected string $table = 'professionals';

    public function allActive(): array
    {
        return $this->db->fetchAll('SELECT * FROM professionals WHERE active = 1 ORDER BY id DESC');
    }
}
