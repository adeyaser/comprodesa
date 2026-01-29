<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ScrapingSourcesSeeder extends Seeder
{
    public function run()
    {
        $sources = [
            [
                'source_name' => 'Tribun Bekasi',
                'url'         => 'https://bekasi.tribunnews.com/',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Detik Bekasi',
                'url'         => 'https://www.detik.com/tag/bekasi/',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Antara Jawa Barat',
                'url'         => 'https://jabar.antaranews.com/bekasi',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Kec. Medan Satria',
                'url'         => 'https://medansatria.bekasikota.go.id/',
                'type'        => 'govt',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Liputan6 Bekasi',
                'url'         => 'https://www.liputan6.com/tag/bekasi',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Info Bekasi',
                'url'         => 'https://infobekasi.co.id/category/news/',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('scraping_sources')->truncate();
        $this->db->table('scraping_sources')->insertBatch($sources);
    }
}
