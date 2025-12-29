<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    private $data;
    private int $statusCode;
    private array $headers;

    public function __construct($data = null, int $statusCode = 200, array $headers = [])
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function send(): void
    {
        // Set HTTP status code
        http_response_code($this->statusCode);
        
        // Set headers
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        
        // Output data as JSON
        if ($this->data !== null) {
            echo json_encode($this->data, JSON_PRETTY_PRINT);
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
