<?php

declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Solo CLI');
}

$dbConfig = require __DIR__ . '/../config/db.php';

require __DIR__ . '/../app/core/Database.php';

$db = Database::getInstance($dbConfig);

$db->execute('CREATE TABLE IF NOT EXISTS schema_migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) NOT NULL UNIQUE, executed_at DATETIME NOT NULL)');

$migrationsDir = __DIR__ . '/../database/migrations';
$files = glob($migrationsDir . '/*.sql');
if ($files === false) {
    exit("No se pudo leer migrations.\n");
}

sort($files);

$applied = $db->fetchAll('SELECT migration FROM schema_migrations');
$appliedMap = [];
foreach ($applied as $row) {
    $appliedMap[$row['migration']] = true;
}

foreach ($files as $file) {
    $name = basename($file);
    if (isset($appliedMap[$name])) {
        continue;
    }
    $sql = file_get_contents($file);
    if ($sql === false) {
        echo "No se pudo leer {$name}\n";
        continue;
    }
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $statement) {
        $db->execute($statement);
    }
    $db->execute(
        'INSERT INTO schema_migrations (migration, executed_at) VALUES (:migration, NOW())',
        ['migration' => $name]
    );
    echo "Aplicada {$name}\n";
}
