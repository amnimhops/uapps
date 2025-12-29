<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    private mixed $data;
    private int $statusCode;
    private array $headers;

    public function __construct($data = null, int $statusCode = 200, array $headers = [])
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = array_merge(['Content-Type' => 'application/json'], $headers);
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
            $json = json_encode($this->data, JSON_PRETTY_PRINT);
            if ($json === false) {
                // Handle JSON encoding errors
                http_response_code(500);
                echo json_encode(['error' => 'JSON encoding failed: ' . json_last_error_msg()]);
                return;
            }
            echo $json;
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
