<?php

declare(strict_types=1);

class ServiceModel extends Model
{
    protected string $table = 'services';

    public function allActive(): array
    {
        return $this->db->fetchAll('SELECT * FROM services WHERE active = 1 ORDER BY id DESC');
    }
}
