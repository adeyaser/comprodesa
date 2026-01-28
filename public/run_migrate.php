<?php
/**
 * MIGRATION RUNNER for CodeIgniter 4.5+
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
    echo "1. Setting up environment...\n";
    
    // Define FCPATH
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    
    // Change to root directory
    chdir(__DIR__ . '/..');
    
    // Load .env file manually
    $envFile = __DIR__ . '/../.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value, " \t\n\r\0\x0B'\"");
                if (!empty($name)) {
                    putenv("$name=$value");
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }
    echo "   OK\n\n";
    
    echo "2. Loading autoloader...\n";
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "   OK\n\n";
    
    echo "3. Booting CodeIgniter...\n";
    // Load Paths config
    require_once __DIR__ . '/../app/Config/Paths.php';
    $paths = new Config\Paths();
    
    // Load the framework bootstrap
    require_once rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Boot.php';
    \CodeIgniter\Boot::bootWeb($paths);
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
    
} catch (\Throwable $e) {
    echo "\n❌ ERROR:\n";
    echo $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString();
}

echo "</pre>";
