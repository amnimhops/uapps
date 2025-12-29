<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    private string $method;
    private string $uri;
    private array $headers;
    private array $queryParams;
    private array $bodyParams;
    private string $rawBody;

    public function __construct(
        string $method,
        string $uri,
        array $headers = [],
        array $queryParams = [],
        array $bodyParams = [],
        string $rawBody = ''
    ) {
        $this->method = strtoupper($method);
        $this->uri = $uri;
        $this->headers = $headers;
        $this->queryParams = $queryParams;
        $this->bodyParams = $bodyParams;
        $this->rawBody = $rawBody;
    }

    public static function fromGlobals(): self
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        
        // Get all headers
        $headers = getallheaders() ?: [];
        
        // Get query parameters
        $queryParams = $_GET;
        
        // Get body parameters
        $rawBody = file_get_contents('php://input');
        $bodyParams = [];
        
        // Parse JSON body if content type is JSON
        $contentType = $headers['Content-Type'] ?? '';
        if (strpos($contentType, 'application/json') !== false && !empty($rawBody)) {
            $bodyParams = json_decode($rawBody, true);
            if ($bodyParams === null && json_last_error() !== JSON_ERROR_NONE) {
                // Log or handle JSON parsing error
                $bodyParams = [];
            }
        } else {
            $bodyParams = $_POST;
        }
        
        return new self($method, $uri, $headers, $queryParams, $bodyParams, $rawBody);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getQueryParam(string $name, $default = null)
    {
        return $this->queryParams[$name] ?? $default;
    }

    public function getBodyParams(): array
    {
        return $this->bodyParams;
    }

    public function getBodyParam(string $name, $default = null)
    {
        return $this->bodyParams[$name] ?? $default;
    }

    public function getRawBody(): string
    {
        return $this->rawBody;
    }
}
