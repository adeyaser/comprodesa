<?php
/**
 * Test accessing homepage route
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Simulate request to /
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PATH_INFO'] = '/';

echo "<pre>";
echo "=== TESTING HOMEPAGE ROUTE ===\n\n";

echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "\n\n";

try {
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    chdir(FCPATH);
    
    require __DIR__ . '/../app/Config/Paths.php';
    $paths = new Config\Paths();
    
    $systemDir = realpath($paths->systemDirectory);
    require_once $systemDir . '/Boot.php';
    
    echo "Booting CodeIgniter with route '/'...\n\n";
    
    \CodeIgniter\Boot::bootWeb($paths);
    
} catch (\Throwable $e) {
    echo "\n❌ EXCEPTION:\n";
    echo "   Type: " . get_class($e) . "\n";
    echo "   Message: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
}

echo "</pre>";
