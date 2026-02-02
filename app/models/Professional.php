<?php
namespace App\Models;

use App\Core\Model;

class Professional extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT professionals.*, users.name AS user_name FROM professionals JOIN users ON users.id = professionals.user_id')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT professionals.*, users.name AS user_name FROM professionals JOIN users ON users.id = professionals.user_id WHERE professionals.id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO professionals (user_id, title, license_number, phone, email) VALUES (:user_id, :title, :license_number, :phone, :email)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE professionals SET user_id = :user_id, title = :title, license_number = :license_number, phone = :phone, email = :email WHERE id = :id');
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM professionals WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
