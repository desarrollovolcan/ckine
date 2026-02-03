<?php

declare(strict_types=1);

class Router
{
    private string $method;
    private string $path;
    private array $routes = [];

    public function __construct(string $method, string $uri)
    {
        $this->method = strtoupper($method);
        $parsed = parse_url($uri);
        $path = $parsed['path'] ?? '/';
        $this->path = rtrim($path, '/') ?: '/';
    }

    public function register(string $method, string $path, array $handler, array $middleware = []): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => rtrim($path, '/') ?: '/',
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(array $config, Database $db): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $this->method) {
                continue;
            }
            if ($route['path'] !== $this->path) {
                continue;
            }

            $this->runMiddleware($route['middleware'], $config, $db);

            [$controllerName, $method] = $route['handler'];
            if (!class_exists($controllerName)) {
                http_response_code(500);
                echo 'Controlador no encontrado';
                return;
            }
            $controller = new $controllerName($config, $db);
            if (!method_exists($controller, $method)) {
                http_response_code(500);
                echo 'Acción no encontrada';
                return;
            }
            $controller->{$method}();
            return;
        }

        http_response_code(404);
        echo 'Página no encontrada';
    }

    private function runMiddleware(array $middlewares, array $config, Database $db): void
    {
        foreach ($middlewares as $middleware) {
            if ($middleware === 'auth') {
                (new AuthMiddleware($config, $db))->handle();
                continue;
            }
            if (str_starts_with($middleware, 'role:')) {
                $role = substr($middleware, 5);
                (new RoleMiddleware($config, $db))->handle($role);
            }
        }
    }
}
