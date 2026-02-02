<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Migrator;

$migrator = new Migrator();
$migrator->migrate(__DIR__ . '/../database/migrations');
