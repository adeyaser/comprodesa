<?php
// Test PHP - Tidak perlu CodeIgniter
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>PHP Test</h1>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "\n";
echo "Script Path: " . __FILE__ . "\n\n";

// Check if vendor exists
echo "Checking files:\n";
echo "vendor/autoload.php: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'EXISTS' : 'NOT FOUND') . "\n";
echo "app/Config/Paths.php: " . (file_exists(__DIR__ . '/../app/Config/Paths.php') ? 'EXISTS' : 'NOT FOUND') . "\n";
echo ".env file: " . (file_exists(__DIR__ . '/../.env') ? 'EXISTS' : 'NOT FOUND') . "\n";
echo "writable folder: " . (is_dir(__DIR__ . '/../writable') ? 'EXISTS' : 'NOT FOUND') . "\n";
echo "writable is writable: " . (is_writable(__DIR__ . '/../writable') ? 'YES' : 'NO') . "\n";

echo "\n=== ENV File Content (first 20 lines) ===\n";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile);
    $count = 0;
    foreach ($lines as $line) {
        // Hide password
        if (stripos($line, 'password') !== false) {
            echo "database.default.password = ****HIDDEN****\n";
        } else {
            echo $line;
        }
        if (++$count >= 20) break;
    }
}

echo "</pre>";
