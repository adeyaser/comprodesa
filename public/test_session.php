<?php
/**
 * Test Session - No output before session
 */
// Start session test
ob_start();

try {
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    chdir(FCPATH);
    
    require __DIR__ . '/../app/Config/Paths.php';
    $paths = new Config\Paths();
    
    $systemDir = realpath($paths->systemDirectory);
    require_once $systemDir . '/Boot.php';
    
    // Capture any output
    $output = ob_get_clean();
    
    // Now output
    echo "<pre>";
    echo "=== SESSION PATH TEST ===\n\n";
    echo "Captured output: " . ($output ?: '(none)') . "\n\n";
    
    // Check session config
    $sessionConfig = new \Config\Session();
    echo "Session Driver: " . $sessionConfig->driver . "\n";
    echo "Session Save Path: " . $sessionConfig->savePath . "\n";
    echo "WRITEPATH constant: " . WRITEPATH . "\n";
    
    $fullPath = WRITEPATH . 'session';
    echo "Full session path: " . $fullPath . "\n";
    echo "Path exists: " . (is_dir($fullPath) ? 'YES' : 'NO') . "\n";
    echo "Path writable: " . (is_writable($fullPath) ? 'YES' : 'NO') . "\n";
    
    // Try to start session manually
    echo "\nTrying to start session...\n";
    $session = \Config\Services::session();
    echo "Session started successfully!\n";
    echo "Session ID: " . session_id() . "\n";
    
    echo "\n=== SUCCESS ===\n";
    echo "</pre>";
    
} catch (\Throwable $e) {
    ob_end_clean();
    echo "<pre>";
    echo "❌ EXCEPTION:\n";
    echo "   Type: " . get_class($e) . "\n";
    echo "   Message: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString();
    echo "</pre>";
}
