<?php
/**
 * Test Session - Simple check
 */
echo "<pre>";
echo "=== SESSION PATH TEST ===\n\n";

// Check writable/session folder directly
$sessionPath = __DIR__ . '/../writable/session';
echo "Session Path: " . realpath($sessionPath) . "\n";
echo "Path exists: " . (is_dir($sessionPath) ? 'YES' : 'NO') . "\n";
echo "Path writable: " . (is_writable($sessionPath) ? 'YES' : 'NO') . "\n\n";

// List files in session folder
echo "Files in session folder:\n";
$files = scandir($sessionPath);
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "   - $file\n";
    }
}
if (count($files) <= 2) {
    echo "   (empty)\n";
}

// Try native PHP session
echo "\nTrying native PHP session...\n";
session_save_path(realpath($sessionPath));
session_start();
$_SESSION['test'] = 'Hello';
echo "Native session works! ID: " . session_id() . "\n";
session_write_close();

echo "\n=== NOW TESTING CODEIGNITER ===\n\n";

// Clean up for CI
session_abort();

echo "Accessing /login directly. Check browser...\n";
echo "</pre>";

// Redirect to login
echo "<p><a href='/login'>Click here to go to Login</a></p>";
echo "<p><a href='/public/login'>Or try /public/login</a></p>";
