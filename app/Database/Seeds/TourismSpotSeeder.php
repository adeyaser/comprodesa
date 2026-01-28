<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TourismSpotSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Danau Duta Harapan',
                'slug'        => 'danau-duta-harapan',
                'description' => '<p>Danau Duta Harapan adalah destinasi wisata air yang asri di kawasan Bekasi Utara. Awalnya berfungsi sebagai penampungan air, kini telah disulap menjadi ruang terbuka publik yang ramah keluarga.</p><p>Fasilitas yang tersedia meliputi jogging track yang nyaman, taman bermain anak, dan spot memancing. Pada sore hari, tempat ini ramai dikunjungi warga untuk berolahraga atau sekadar menikmati matahari terbenam.</p><p>Pemerintah Kota Bekasi rutin menebar benih ikan di danau ini untuk menjaga ekosistem. Selain itu, tersedia juga Wi-Fi gratis bagi pengunjung.</p>',
                'location'    => 'Kawasan Duta Harapan, Harapan Baru',
                'thumbnail'   => 'danau_duta.svg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Wisata Kuliner Harapan Indah',
                'slug'        => 'wisata-kuliner-harapan-indah',
                'description' => '<p>Kawasan Kota Harapan Indah dikenal sebagai surga kuliner di Bekasi. Mulai dari jajanan kaki lima hingga restoran berkelas, semuanya tersedia di sepanjang jalan utama boulevard ini.</p><p>Beberapa spot legendaris yang wajib dicoba antara lain Bakso Gepeng si Kumis, Sate Taichan, dan Bebek Kaleyo. Kawasan ini hidup 24 jam dan menjadi tempat nongkrong favorit anak muda maupun keluarga di akhir pekan.</p>',
                'location'    => 'Jl. Boulevard Harapan Indah, Medan Satria',
                'thumbnail'   => 'kuliner_hi.svg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Kolam Renang THB (Taman Harapan Baru)',
                'slug'        => 'kolam-renang-thb',
                'description' => '<p>Destinasi wisata air keluarga dengan harga terjangkau. Kolam Renang THB menawarkan berbagai wahana air seperti perosotan spiral, ember tumpah, dan kolam arus yang menyenangkan bagi anak-anak.</p><p>Fasilitas penunjang seperti kamar bilas yang bersih, kantin, dan area tunggu yang teduh menjadikan tempat ini pilihan tepat untuk liburan singkat di tengah kota.</p>',
                'location'    => 'Taman Harapan Baru, Medan Satria',
                'thumbnail'   => 'thb_pool.svg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Sentra Ikan Hias & Tanaman Medan Satria',
                'slug'        => 'sentra-ikan-hias-medan-satria',
                'description' => '<p>Bagi penghobi aquascape dan tanaman hias, lokasi ini adalah surga tersembunyi. Deretan kios menawarkan berbagai jenis ikan hias air tawar, tanaman air, hingga perlengkapan akuarium dengan harga miring.</p><p>Selain ikan, terdapat juga pedagang tanaman hias yang menjual Aglonema, Monstera, dan berbagai tanaman pot lainnya untuk mempercantik rumah Anda.</p>',
                'location'    => 'Jl. Sultan Agung, Medan Satria',
                'thumbnail'   => 'ikan_hias.svg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Danau Indah Kali Baru',
                'slug'        => 'danau-indah-kali-baru',
                'description' => '<p>Destinasi wisata alam "hidden gem" di Kelurahan Kali Baru. Danau ini menawarkan pemandangan asri dengan suasana pedesaan yang kental di tengah kota.</p><p>Pengunjung bisa menikmati kegiatan memancing, bersantai di gazebo, atau berkeliling danau menggunakan perahu getek. Lokasi ini sedang dalam tahap pengembangan oleh Pokdarwis setempat untuk menjadi ikon wisata baru.</p>',
                'location'    => 'Jl. Kp. Rw. Bambu No.54, Kali Baru, Medan Satria',
                'thumbnail'   => 'danau_kalibaru.svg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Disable FK checks
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');

        // Truncate Tables
        $this->db->table('tourism_gallery')->truncate();
        $this->db->table('tourism_spots')->truncate();

        // Insert Data
        $this->db->table('tourism_spots')->insertBatch($data);
        
        // Get IDs for Gallery
        $db = \Config\Database::connect();
        $spots = $db->table('tourism_spots')->get()->getResultArray();
        
        // Populate Gallery
        $galleryData = [];
        foreach($spots as $spot) {
             // Add 3 dummy gallery items per spot
             for($i=1; $i<=3; $i++) {
                 $galleryData[] = [
                     'spot_id' => $spot['id'],
                     'image'   => $spot['slug'] . '_gal_' . $i . '.svg',
                     'caption' => 'Suasana di ' . $spot['name'] . ' ' . $i
                 ];
             }
        }
        $this->db->table('tourism_gallery')->insertBatch($galleryData);
        
        // Enable FK checks
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
