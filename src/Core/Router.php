<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        // Register default routes
        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        // Health check endpoint
        $this->addRoute('GET', '/', function (Request $request) {
            return new Response([
                'status' => 'ok',
                'message' => 'uapps REST API is running',
                'version' => '1.0.0',
                'timestamp' => date('c')
            ]);
        });

        // API info endpoint
        $this->addRoute('GET', '/api', function (Request $request) {
            return new Response([
                'name' => 'uapps REST API',
                'version' => '1.0.0',
                'endpoints' => [
                    'GET /' => 'Health check',
                    'GET /api' => 'API information'
                ]
            ]);
        });

        // Example endpoint
        $this->addRoute('GET', '/api/example', function (Request $request) {
            return new Response([
                'message' => 'This is an example endpoint',
                'method' => $request->getMethod(),
                'uri' => $request->getUri()
            ]);
        });
    }

    public function addRoute(string $method, string $path, callable $handler): void
    {
        $method = strtoupper($method);
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }
        $this->routes[$method][$path] = $handler;
    }

    public function handle(Request $request): Response
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        // Remove trailing slash if present (except for root)
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        // Check if route exists
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            return $handler($request);
        }

        // Route not found
        return new Response([
            'error' => 'Not Found',
            'message' => "The requested endpoint $method $uri does not exist"
        ], 404);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
