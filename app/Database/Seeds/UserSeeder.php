<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'  => 'admin',
            'password'  => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name' => 'Administrator Desa',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        // Simple check to avoid duplicates if table not truncated
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('username', 'admin')->get()->getRow();
        
        if (!$user) {
            $this->db->table('users')->insert($data);
            echo "Admin user created successfully (username: admin, password: admin123)\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}
