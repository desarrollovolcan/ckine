<?php
namespace App\Models;

use App\Core\Model;

class AuditLog extends Model
{
    public function log(?int $userId, string $action, string $entity, ?int $entityId, array $detail = []): void
    {
        $stmt = $this->db->prepare('INSERT INTO audit_logs (user_id, action, entity, entity_id, detail_json) VALUES (:user_id, :action, :entity, :entity_id, :detail_json)');
        $stmt->execute([
            'user_id' => $userId,
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
            'detail_json' => json_encode($detail),
        ]);
    }

    public function all(int $limit = 200): array
    {
        $stmt = $this->db->prepare('SELECT audit_logs.*, users.name AS user_name FROM audit_logs LEFT JOIN users ON users.id = audit_logs.user_id ORDER BY audit_logs.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
