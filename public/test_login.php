<?php
/**
 * Test Login Route
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre>";
echo "=== TESTING LOGIN ROUTE ===\n\n";

// Simulate request to /login
$_SERVER['REQUEST_URI'] = '/login';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_METHOD'] = 'GET';

try {
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    chdir(FCPATH);
    
    require __DIR__ . '/../app/Config/Paths.php';
    $paths = new Config\Paths();
    
    $systemDir = realpath($paths->systemDirectory);
    require_once $systemDir . '/Boot.php';
    
    echo "Booting CodeIgniter with route '/login'...\n\n";
    
    \CodeIgniter\Boot::bootWeb($paths);
    
} catch (\Throwable $e) {
    echo "\n❌ EXCEPTION:\n";
    echo "   Type: " . get_class($e) . "\n";
    echo "   Message: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString();
}

echo "</pre>";
