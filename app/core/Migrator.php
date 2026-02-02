<?php
namespace App\Core;

use PDO;

class Migrator
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DB::connection();
    }

    public function migrate(string $path): void
    {
        $this->ensureMigrationsTable();
        $files = glob(rtrim($path, '/') . '/*.sql');
        sort($files);
        foreach ($files as $file) {
            $filename = basename($file);
            if ($this->isMigrated($filename)) {
                continue;
            }
            $sql = file_get_contents($file);
            $this->db->exec($sql);
            $stmt = $this->db->prepare('INSERT INTO schema_migrations (filename, executed_at) VALUES (:filename, NOW())');
            $stmt->execute(['filename' => $filename]);
            echo "Migrated: {$filename}\n";
        }
    }

    private function ensureMigrationsTable(): void
    {
        $this->db->exec('CREATE TABLE IF NOT EXISTS schema_migrations (id INT AUTO_INCREMENT PRIMARY KEY, filename VARCHAR(255) NOT NULL, executed_at DATETIME NOT NULL)');
    }

    private function isMigrated(string $filename): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM schema_migrations WHERE filename = :filename');
        $stmt->execute(['filename' => $filename]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
