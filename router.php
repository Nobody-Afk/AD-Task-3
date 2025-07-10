<?php
require __DIR__ . '/bootstrap.php';

if (php_sapi_name() === 'cli-server') {
    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Remove query parameters from the path
    $urlPath = strtok($urlPath, '?');
    
    // Check if it's a static file (css, js, images, etc.)
    if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $urlPath)) {
        return false; // Serve static files directly
    }
    
    // Check if the requested file exists
    $file = BASE_PATH . $urlPath;
    if (is_file($file)) {
        return false; // Let PHP serve the file
    }
    
    // Check for directory with index.php
    if (is_dir($file) && is_file($file . '/index.php')) {
        require $file . '/index.php';
        return true;
    }
}

// Default fallback to main index.php
require BASE_PATH . '/index.php';
