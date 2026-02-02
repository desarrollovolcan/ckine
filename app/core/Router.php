<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action, array $middleware = []): void
    {
        $this->add('GET', $uri, $action, $middleware);
    }

    public function post(string $uri, array $action, array $middleware = []): void
    {
        $this->add('POST', $uri, $action, $middleware);
    }

    public function put(string $uri, array $action, array $middleware = []): void
    {
        $this->add('PUT', $uri, $action, $middleware);
    }

    public function delete(string $uri, array $action, array $middleware = []): void
    {
        $this->add('DELETE', $uri, $action, $middleware);
    }

    private function add(string $method, string $uri, array $action, array $middleware): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'action' => $action,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');
        $app = require __DIR__ . '/../../config/app.php';
        $basePath = trim($app['base_url'], '/');
        if ($basePath !== '' && $basePath !== '/') {
            if (str_starts_with($uri, $basePath)) {
                $uri = trim(substr($uri, strlen($basePath)), '/');
            }
        }

        foreach ($this->routes as $route) {
            $pattern = $this->buildPattern($route['uri']);
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->runMiddleware($route['middleware']);
                $controller = new $route['action'][0]();
                $action = $route['action'][1];
                $controller->$action(...$matches);
                return;
            }
        }

        http_response_code(404);
        View::render('errors/404', ['title' => 'No encontrado']);
    }

    private function buildPattern(string $uri): string
    {
        $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_-]+)', $uri);
        return '#^' . $pattern . '$#';
    }

    private function runMiddleware(array $middleware): void
    {
        foreach ($middleware as $middlewareClass) {
            $instance = new $middlewareClass();
            $instance->handle();
        }
    }
}
