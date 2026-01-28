<?php
/**
 * Test loading CodeIgniter directly
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre>";
echo "=== TESTING CODEIGNITER LOAD ===\n\n";

try {
    // Set error handler
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        echo "PHP Error [$errno]: $errstr\n";
        echo "   File: $errfile\n";
        echo "   Line: $errline\n\n";
        return true;
    });
    
    echo "1. Define FCPATH...\n";
    if (!defined('FCPATH')) {
        define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    }
    echo "   FCPATH = " . FCPATH . "\n";
    echo "   OK\n\n";
    
    echo "2. Change directory...\n";
    chdir(FCPATH);
    echo "   CWD = " . getcwd() . "\n";
    echo "   OK\n\n";
    
    echo "3. Load Paths...\n";
    require __DIR__ . '/../app/Config/Paths.php';
    $paths = new Config\Paths();
    echo "   App: " . $paths->appDirectory . "\n";
    echo "   System: " . $paths->systemDirectory . "\n";
    echo "   Writable: " . $paths->writableDirectory . "\n";
    echo "   OK\n\n";
    
    echo "4. Check system directory exists...\n";
    $systemDir = realpath($paths->systemDirectory);
    echo "   Resolved: " . ($systemDir ?: 'FAILED') . "\n";
    if (!$systemDir) {
        throw new Exception("System directory not found: " . $paths->systemDirectory);
    }
    echo "   OK\n\n";
    
    echo "5. Check Boot.php exists...\n";
    $bootFile = $systemDir . '/Boot.php';
    echo "   Path: $bootFile\n";
    echo "   Exists: " . (file_exists($bootFile) ? 'YES' : 'NO') . "\n";
    if (!file_exists($bootFile)) {
        throw new Exception("Boot.php not found!");
    }
    echo "   OK\n\n";
    
    echo "6. Loading Boot.php...\n";
    require_once $bootFile;
    echo "   OK\n\n";
    
    echo "7. Calling Boot::bootWeb()...\n";
    // Capture output
    ob_start();
    try {
        \CodeIgniter\Boot::bootWeb($paths);
    } catch (\Throwable $e) {
        $output = ob_get_clean();
        echo "   Output before error: " . substr($output, 0, 500) . "\n";
        throw $e;
    }
    
} catch (\Throwable $e) {
    echo "\n❌ EXCEPTION:\n";
    echo "   Type: " . get_class($e) . "\n";
    echo "   Message: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString();
}

echo "\n</pre>";
