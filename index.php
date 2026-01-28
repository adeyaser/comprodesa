<?php
/**
 * Simple Router - Redirect all requests to public/index.php
 * Place this in root folder
 */

// Get the request URI
$uri = $_SERVER['REQUEST_URI'];

// Remove query string if present
$uri = parse_url($uri, PHP_URL_PATH);

// If URI ends with a file that exists in public, serve it
$publicPath = __DIR__ . '/public' . $uri;
if (is_file($publicPath)) {
    return false; // Let the server handle static files
}

// Otherwise, include public/index.php
$_SERVER['SCRIPT_NAME'] = '/index.php';
chdir(__DIR__ . '/public');
require __DIR__ . '/public/index.php';
