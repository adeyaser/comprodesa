<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ScrapingSourcesSeeder extends Seeder
{
    public function run()
    {
        $sources = [
            // Portal Berita Lokal
            [
                'source_name' => 'GoBekasi',
                'url'         => 'https://gobekasi.id/lokal-daerah/kota-bekasi/',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Radar Bekasi',
                'url'         => 'https://radarbekasi.id/category/bekasi-kota/',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Info Bekasi',
                'url'         => 'https://infobekasi.co.id/',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Bekasi Satu',
                'url'         => 'https://www.bekasisatu.com/',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            // Pemerintah
            [
                'source_name' => 'Pemkot Bekasi',
                'url'         => 'https://www.bekasikota.go.id/berita',
                'type'        => 'govt',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'PPID Bekasi',
                'url'         => 'https://ppid.bekasikota.go.id/',
                'type'        => 'govt',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            // Media Nasional (Regional)
            [
                'source_name' => 'Detik News (Tag: Bekasi)',
                'url'         => 'https://www.detik.com/tag/bekasi',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Kompas Regional (Search: Bekasi)',
                'url'         => 'https://regional.kompas.com/search?q=bekasi',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'source_name' => 'Tribun Jakarta (Bekasi)',
                'url'         => 'https://jakarta.tribunnews.com/bekasi',
                'type'        => 'portal',
                'status'      => 'active',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('scraping_sources')->truncate();
        $this->db->table('scraping_sources')->insertBatch($sources);
    }
}
