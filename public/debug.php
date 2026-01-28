<?php
/**
 * Debug script - cek error apa yang terjadi
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre>";
echo "=== DEBUG INFO ===\n\n";

// 1. Check PHP
echo "1. PHP Version: " . phpversion() . "\n\n";

// 2. Check .env
echo "2. ENV File:\n";
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $content = file_get_contents($envFile);
    // Show first part without password
    $lines = explode("\n", $content);
    foreach ($lines as $line) {
        if (stripos($line, 'password') !== false) {
            echo "   database.default.password = ***HIDDEN***\n";
        } else {
            echo "   " . $line . "\n";
        }
    }
} else {
    echo "   NOT FOUND!\n";
}

// 3. Check writable
echo "\n3. Writable folders:\n";
$folders = ['writable', 'writable/cache', 'writable/logs', 'writable/session'];
foreach ($folders as $folder) {
    $path = __DIR__ . '/../' . $folder;
    $exists = is_dir($path) ? 'EXISTS' : 'NOT FOUND';
    $writable = is_writable($path) ? 'WRITABLE' : 'NOT WRITABLE';
    echo "   $folder: $exists, $writable\n";
}

// 4. Check .htaccess
echo "\n4. .htaccess files:\n";
echo "   Root .htaccess: " . (file_exists(__DIR__ . '/../.htaccess') ? 'EXISTS' : 'NOT FOUND') . "\n";
echo "   Public .htaccess: " . (file_exists(__DIR__ . '/.htaccess') ? 'EXISTS' : 'NOT FOUND') . "\n";

// 5. Show root .htaccess content
echo "\n5. Root .htaccess content:\n";
$htaccess = __DIR__ . '/../.htaccess';
if (file_exists($htaccess)) {
    echo file_get_contents($htaccess);
}

// 6. Show public .htaccess content
echo "\n6. Public .htaccess content:\n";
$htaccessPublic = __DIR__ . '/.htaccess';
if (file_exists($htaccessPublic)) {
    echo file_get_contents($htaccessPublic);
}

echo "\n=== END DEBUG ===\n";
echo "</pre>";
