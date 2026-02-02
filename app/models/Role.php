<?php
namespace App\Models;

use App\Core\Model;

class Role extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM roles')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM roles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO roles (name, description) VALUES (:name, :description)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE roles SET name = :name, description = :description WHERE id = :id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM roles WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
