<?php

declare(strict_types=1);

return [
    'app' => [
        'name' => 'uapps REST API',
        'version' => '1.0.0',
        'env' => getenv('APP_ENV') ?: 'development',
        'debug' => getenv('APP_DEBUG') ?: true,
    ],
    
    'cors' => [
        'enabled' => true,
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization'],
    ],
    
    'database' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => getenv('DB_PORT') ?: 3306,
        'name' => getenv('DB_NAME') ?: 'uapps',
        'user' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
    ],
];
