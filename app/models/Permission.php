<?php
namespace App\Models;

use App\Core\Model;

class Permission extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM permissions')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM permissions WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
