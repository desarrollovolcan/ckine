<?php
namespace App\Models;

use App\Core\Model;

class Service extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM services ORDER BY name')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM services WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO services (name, duration_minutes, price, description) VALUES (:name, :duration_minutes, :price, :description)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE services SET name = :name, duration_minutes = :duration_minutes, price = :price, description = :description WHERE id = :id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM services WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
