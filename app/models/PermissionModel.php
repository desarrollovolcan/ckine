<?php

declare(strict_types=1);

class PermissionModel extends Model
{
    protected string $table = 'permissions';

    public function allOrdered(): array
    {
        return $this->db->fetchAll('SELECT * FROM permissions ORDER BY label');
    }
}
