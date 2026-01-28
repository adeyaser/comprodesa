<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Default Admin (password: admin123)
        $userData = [
            'username'   => 'admin',
            'password'   => password_hash('admin123', PASSWORD_BCRYPT),
            'full_name'  => 'Administrator Desa',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('users')->insert($userData);

        // Initial Village Config
        $villageData = [
            'village_name'    => 'Desa Contoh',
            'village_address' => 'Jl. Merdeka No. 1, Kabupaten Maju Jaya',
            'village_phone'   => '08123456789',
            'village_email'   => 'info@desacontoh.go.id',
            'village_history' => 'Desa Contoh didirikan pada tahun 1945...',
            'village_vision'  => 'Mewujudkan desa yang mandiri dan berdaya saing.',
            'village_mission' => '1. Meningkatkan layanan publik. 2. Mengembangkan potensi lokal.',
        ];
        $this->db->table('village_config')->insert($villageData);

        // Initial News Categories
        $categories = [
            ['name' => 'Warta Desa', 'slug' => 'warta-desa'],
            ['name' => 'Kategori Umum', 'slug' => 'umum'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman'],
        ];
        $this->db->table('news_categories')->insertBatch($categories);
    }
}
