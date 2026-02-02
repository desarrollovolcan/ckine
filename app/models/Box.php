<?php
namespace App\Models;

use App\Core\Model;

class Box extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM boxes ORDER BY name')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM boxes WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO boxes (name, description, is_active) VALUES (:name, :description, :is_active)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE boxes SET name = :name, description = :description, is_active = :is_active WHERE id = :id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM boxes WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
