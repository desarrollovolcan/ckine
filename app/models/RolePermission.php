<?php
namespace App\Models;

use App\Core\Model;

class RolePermission extends Model
{
    public function getPermissionsForRole(int $roleId): array
    {
        $stmt = $this->db->prepare('SELECT permission_id FROM role_permissions WHERE role_id = :role_id');
        $stmt->execute(['role_id' => $roleId]);
        return array_column($stmt->fetchAll(), 'permission_id');
    }

    public function sync(int $roleId, array $permissionIds): void
    {
        $this->db->prepare('DELETE FROM role_permissions WHERE role_id = :role_id')->execute(['role_id' => $roleId]);
        $stmt = $this->db->prepare('INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)');
        foreach ($permissionIds as $permissionId) {
            $stmt->execute(['role_id' => $roleId, 'permission_id' => (int) $permissionId]);
        }
    }
}
