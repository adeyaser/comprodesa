<?php
/**
 * MIGRATION RUNNER
 * ================
 * Jalankan file ini SEKALI untuk setup database di production
 * HAPUS FILE INI SETELAH SELESAI!
 * 
 * Akses: https://kalibaru.my.id/run_migrate.php
 */

// Security check - hapus baris ini jika tidak bisa akses
$secret = $_GET['key'] ?? '';
if ($secret !== 'kalibaru2026') {
    die('Unauthorized. Akses: run_migrate.php?key=kalibaru2026');
}

require_once __DIR__ . '/../vendor/autoload.php';

// Boot CodeIgniter
$paths = new \Config\Paths();
require_once SYSTEMPATH . 'bootstrap.php';

$app = \Config\Services::codeigniter();
$app->initialize();

echo "<!DOCTYPE html><html><head><title>Migration Runner</title>";
echo "<style>body{font-family:monospace;padding:20px;background:#1e1e1e;color:#0f0;}</style></head><body>";
echo "<h2>🚀 Database Migration Runner</h2><hr>";

try {
    // Run migrations
    echo "<h3>1. Running Migrations...</h3>";
    $migrate = \Config\Services::migrations();
    
    if ($migrate->latest()) {
        echo "<p style='color:#0f0;'>✅ Migrations completed successfully!</p>";
    } else {
        echo "<p style='color:#ff0;'>⚠️ No new migrations to run.</p>";
    }
    
    // Show migration status
    echo "<h3>2. Migration Status:</h3><pre>";
    $db = \Config\Database::connect();
    $query = $db->table('migrations')->get();
    foreach ($query->getResult() as $row) {
        echo "✓ " . $row->class . "\n";
    }
    echo "</pre>";
    
    // Check if users table has data
    echo "<h3>3. Checking Users Table...</h3>";
    $userModel = new \App\Models\UserModel();
    $userCount = $userModel->countAll();
    
    if ($userCount == 0) {
        echo "<p style='color:#ff0;'>⚠️ No users found. Creating default admin...</p>";
        
        // Create default admin
        $userModel->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'Administrator',
            'email' => 'admin@kalibaru.my.id',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        echo "<p style='color:#0f0;'>✅ Default admin created!</p>";
        echo "<p>Username: <strong>admin</strong></p>";
        echo "<p>Password: <strong>admin123</strong></p>";
    } else {
        echo "<p style='color:#0f0;'>✅ Found {$userCount} user(s) in database.</p>";
    }
    
    echo "<hr>";
    echo "<h3 style='color:#f00;'>⚠️ PENTING: HAPUS FILE INI SETELAH SELESAI!</h3>";
    echo "<p>File: public/run_migrate.php</p>";
    echo "<p><a href='/' style='color:#0ff;'>→ Kembali ke Homepage</a></p>";
    echo "<p><a href='/login' style='color:#0ff;'>→ Ke Halaman Login</a></p>";
    
} catch (\Exception $e) {
    echo "<h3 style='color:#f00;'>❌ Error:</h3>";
    echo "<pre style='color:#f00;'>" . $e->getMessage() . "</pre>";
    echo "<pre style='color:#ff0;'>" . $e->getTraceAsString() . "</pre>";
}

echo "</body></html>";
