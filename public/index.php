<?php
declare(strict_types=1);

use App\Core\Router;

session_start();

$root = dirname(__DIR__);
require_once $root . '/app/bootstrap.php';

$router = new Router();

require $root . '/app/routes.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}

$router->dispatch($method, $_SERVER['REQUEST_URI'] ?? '/');
