# uapps

A pure REST PHP service that acts as a shared backend for multiple frontend applications.

## Features

- Pure REST API architecture
- Modern PHP 8.0+ with strict typing
- PSR-4 autoloading
- JSON-based request/response handling
- CORS support for cross-origin requests
- Modular and extensible structure
- Clean separation of concerns

## Requirements

- PHP 8.0 or higher
- Composer
- Apache with mod_rewrite (or equivalent web server)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/amnimhops/uapps.git
cd uapps
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment (optional):
```bash
cp .env.example .env
# Edit .env with your configuration
```

4. Configure your web server to point to the `public` directory as the document root.

### Apache Configuration Example

```apache
<VirtualHost *:80>
    ServerName uapps.local
    DocumentRoot /path/to/uapps/public
    
    <Directory /path/to/uapps/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Testing the API

You can test the API using curl, Postman, or any HTTP client.

### Health Check
```bash
curl http://localhost/
```

Expected response:
```json
{
    "status": "ok",
    "message": "uapps REST API is running",
    "version": "1.0.0",
    "timestamp": "2025-12-29T12:00:00+00:00"
}
```

### API Information
```bash
curl http://localhost/api
```

### Example Endpoint
```bash
curl http://localhost/api/example
```

## Project Structure

```
uapps/
├── config/          # Configuration files
│   └── config.php   # Main configuration
├── public/          # Public web directory (document root)
│   ├── .htaccess    # Apache URL rewriting rules
│   └── index.php    # Application entry point
├── src/             # Application source code
│   └── Core/        # Core framework classes
│       ├── Request.php   # HTTP request handler
│       ├── Response.php  # HTTP response handler
│       └── Router.php    # REST API router
├── tests/           # Test files
├── .env.example     # Environment variables template
├── .gitignore       # Git ignore rules
├── composer.json    # PHP dependencies
└── README.md        # This file
```

## Adding New Endpoints

To add new endpoints, modify the `registerRoutes()` method in `src/Core/Router.php`:

```php
$this->addRoute('GET', '/api/your-endpoint', function (Request $request) {
    return new Response([
        'data' => 'Your response data'
    ]);
});

$this->addRoute('POST', '/api/your-endpoint', function (Request $request) {
    $data = $request->getBodyParams();
    // Process the data
    return new Response([
        'success' => true,
        'data' => $data
    ], 201);
});
```

## API Design

This REST API follows these principles:

- **Stateless**: Each request contains all necessary information
- **JSON**: All requests and responses use JSON format
- **HTTP Methods**: Proper use of GET, POST, PUT, DELETE
- **Status Codes**: Appropriate HTTP status codes (200, 201, 404, 500, etc.)
- **CORS**: Cross-Origin Resource Sharing enabled for frontend integration

## Development

The application is designed to be refined and extended. The current skeleton provides:

- Basic routing infrastructure
- Request/Response handling
- JSON serialization
- Error handling
- CORS support

Future enhancements can include:
- Database integration
- Authentication/Authorization
- Validation middleware
- Logging
- Rate limiting
- API documentation (Swagger/OpenAPI)

## License

MIT License - see LICENSE file for details.