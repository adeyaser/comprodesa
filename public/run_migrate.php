<?php
/**
 * MIGRATION RUNNER - Simple Version
 * Akses: https://kalibaru.my.id/run_migrate.php?key=kalibaru2026
 * HAPUS FILE INI SETELAH SELESAI!
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Security check
$secret = $_GET['key'] ?? '';
if ($secret !== 'kalibaru2026') {
    die('Unauthorized. Akses: run_migrate.php?key=kalibaru2026');
}

echo "<pre>";
echo "=== MIGRATION RUNNER ===\n\n";

try {
    echo "1. Loading autoloader...\n";
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "   OK\n\n";
    
    echo "2. Loading Paths...\n";
    $paths = new \Config\Paths();
    echo "   OK\n\n";
    
    echo "3. Loading Bootstrap...\n";
    require_once SYSTEMPATH . 'bootstrap.php';
    echo "   OK\n\n";
    
    echo "4. Connecting to database...\n";
    $db = \Config\Database::connect();
    echo "   Driver: " . $db->getPlatform() . "\n";
    echo "   Database: " . $db->getDatabase() . "\n";
    echo "   OK\n\n";
    
    echo "5. Running migrations...\n";
    $migrate = \Config\Services::migrations();
    $migrate->latest();
    echo "   OK\n\n";
    
    echo "6. Checking users table...\n";
    $userCount = $db->table('users')->countAll();
    echo "   Found: {$userCount} users\n\n";
    
    if ($userCount == 0) {
        echo "7. Creating default admin...\n";
        $db->table('users')->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'Administrator',
            'email' => 'admin@kalibaru.my.id',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        echo "   Admin created!\n";
        echo "   Username: admin\n";
        echo "   Password: admin123\n\n";
    }
    
    echo "=== DONE ===\n";
    echo "\n⚠️  HAPUS FILE INI SETELAH SELESAI!\n";
    echo "\nKlik: <a href='/login'>Login Page</a>\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR:\n";
    echo $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString();
}

echo "</pre>";
