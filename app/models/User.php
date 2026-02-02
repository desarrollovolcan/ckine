<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT users.*, roles.name AS role_name FROM users JOIN roles ON roles.id = users.role_id')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT users.*, roles.name AS role_name FROM users JOIN roles ON roles.id = users.role_id WHERE users.id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO users (name, email, password_hash, role_id, must_change_password, is_active) VALUES (:name, :email, :password_hash, :role_id, :must_change_password, :is_active)');
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare('UPDATE users SET name = :name, email = :email, role_id = :role_id, must_change_password = :must_change_password, is_active = :is_active WHERE id = :id');
        $stmt->execute($data);
    }

    public function updatePassword(int $id, string $hash): void
    {
        $stmt = $this->db->prepare('UPDATE users SET password_hash = :hash, must_change_password = 0 WHERE id = :id');
        $stmt->execute(['hash' => $hash, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function roleHasPermission(int $roleId, string $permissionKey): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM role_permissions rp JOIN permissions p ON p.id = rp.permission_id WHERE rp.role_id = :role_id AND p.`key` = :permission');
        $stmt->execute(['role_id' => $roleId, 'permission' => $permissionKey]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
