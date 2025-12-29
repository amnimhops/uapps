<?php

declare(strict_types=1);

// Set error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Request;
use App\Core\Response;

try {
    // Initialize router
    $router = new Router();
    
    // Create request from globals
    $request = Request::fromGlobals();
    
    // Handle the request
    $response = $router->handle($request);
    
    // Send the response
    $response->send();
    
} catch (Exception $e) {
    // Handle any uncaught exceptions
    $response = new Response(
        ['error' => $e->getMessage()],
        500
    );
    $response->send();
}
