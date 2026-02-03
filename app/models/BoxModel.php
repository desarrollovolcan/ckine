<?php

declare(strict_types=1);

class BoxModel extends Model
{
    protected string $table = 'boxes';

    public function allActive(): array
    {
        return $this->db->fetchAll('SELECT * FROM boxes WHERE status = "activo" ORDER BY id DESC');
    }
}
