<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KaliBaruSeeder extends Seeder
{
    public function run()
    {
        // 0. Disable FK Checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        
        // 1. Users (Ensure Admin exists first)
        $adminExist = $this->db->table('users')->where('username', 'admin')->get()->getRowArray();
        $userId = 1;
        
        if (!$adminExist) {
            $this->db->table('users')->insert([
                'username'  => 'admin',
                'password'  => password_hash('admin123', PASSWORD_BCRYPT),
                'full_name' => 'Administrator Kali Baru',
                'email'     => 'admin@kalibaru.desa.id',
                'role'      => 'admin',
                'created_at'=> date('Y-m-d H:i:s'),
            ]);
            $userId = $this->db->insertID();
        } else {
            $userId = $adminExist['id'];
        }

        // 2. Village Config
        $configData = [
            'village_name'    => 'Kali Baru',
            'app_name'        => 'Portal Kelurahan Kali Baru',
            'village_logo'    => 'logo_bekasi.jpg', 
            'village_address' => 'Jl. Jend. Sudirman No. 1, Kali Baru, Kecamatan Medan Satria, Kota Bekasi, Jawa Barat 17133',
            'village_phone'   => '(021) 8841234',
            'village_email'   => 'kelurahan.kalibaru@bekasikota.go.id',
            'village_history' => 'Kelurahan Kali Baru merupakan salah satu kelurahan di Kecamatan Medan Satria, Kota Bekasi. Wilayah ini sebelumnya merupakan bagian dari Kecamatan Bekasi Barat sebelum pemekaran pada tahun 2000. Dengan luas wilayah sekitar 121 hektar, Kelurahan Kali Baru terbagi menjadi 12 RW dan 69 RT, meliputi Kampung Rawa Bambu dan Kampung Rawa Pasung Timur. Wilayah ini terus berkembang menjadi kawasan penyangga Kota Jakarta dengan dinamika perkotaan yang tinggi.',
            'village_vision'  => 'Mewujudkan Kelurahan Kali Baru yang Maju, Sejahtera dan Ihsan dalam Tata Kelola Pemerintahan yang Baik.',
            'village_mission' => "1. Meningkatkan kualitas pelayanan publik yang prima.\n2. Mengembangkan potensi pemberdayaan masyarakat.\n3. Menciptakan lingkungan yang bersih, tertib, dan aman.\n4. Meningkatkan kualitas infrastruktur lingkungan.",
        ];

        $this->db->table('village_config')->truncate();
        $this->db->table('village_config')->insert($configData);

        // 3. News Categories & News
        $newsData = [
            [
                'title'         => 'Warga Terdampak Banjir Kembali ke Rumah, Posko Pengungsian Ditutup',
                'slug'          => 'warga-terdampak-banjir-kembali-ke-rumah',
                'content'       => '<p>Bekasi, 25 Januari 2026 - Sebanyak puluhan warga Kelurahan Kali Baru yang sebelumnya mengungsi akibat banjir luapan kali yang terjadi beberapa hari lalu, kini mulai kembali ke rumah masing-masing.</p><p>Lurah Kali Baru menyampaikan bahwa genangan air di titik-titik terparah, seperti di RW 03 dan RW 04, telah surut sepenuhnya. "Alhamdulillah, hari ini posko pengungsian di aula kelurahan resmi kami tutup seiring membaiknya kondisi lapangan," ujarnya saat ditemui Minggu pagi.</p><p>Petugas PPSU dan relawan kini fokus membantu warga membersihkan sisa lumpur dan sampah yang terbawa arus banjir.</p>',
                'thumbnail'     => 'flood_release.jpg',
                'category_id'   => 1,
                'author_id'     => $userId, // Corrected column name
                'created_at'    => '2026-01-25 08:00:00',
            ],
            [
                'title'         => 'Persiapan Lebaran Bekasi 2026: Kelurahan Kali Baru Rencanakan Pawai Budaya',
                'slug'          => 'persiapan-lebaran-bekasi-2026-pawai-budaya',
                'content'       => '<p>Menyambut gelaran tahunan Lebaran Bekasi yang akan dilaksanakan pasca Idul Fitri nanti, Kelurahan Kali Baru mulai membentuk panitia persiapan Pawai Budaya.</p><p>Kegiatan ini bertujuan untuk melestarikan budaya Betawi yang kental di wilayah Bekasi, khususnya seni Silat dan kuliner khas seperti Gabus Pucung. "Tahun ini kami ingin mengirimkan kontingen terbaik yang menampilkan perpaduan budaya tradisional dan kreativitas pemuda Kali Baru," ungkap Ketua Karang Taruna setempat.</p>',
                'thumbnail'     => 'culture_fest.jpg',
                'category_id'   => 2,
                'author_id'     => $userId,
                'created_at'    => '2026-01-20 10:00:00',
            ],
             [
                'title'         => 'Penertiban Bangunan Liar di Bantaran Kali untuk Cegah Banjir Susulan',
                'slug'          => 'penertiban-bangli-bantaran-kali',
                'content'       => '<p>Pemerintah Kota Bekasi melalui Kecamatan Medan Satria kembali melakukan penertiban bangunan liar (bangli) di sepanjang bantaran irigasi Kali Baru. Langkah ini diambil sebagai upaya mitigasi banjir jangka panjang.</p><p>Camat Medan Satria menegaskan bahwa normalisasi saluran air tidak akan optimal jika sempadan sungai tertutup bangunan permanen. "Kami sudah memberikan surat peringatan ketiga, dan hari ini pembongkaran dilakukan secara persuasif," tegasnya.</p>',
                'thumbnail'     => 'cleanup.jpg',
                'category_id'   => 1,
                'author_id'     => $userId,
                'created_at'    => '2026-01-15 14:30:00',
            ],
            [
                'title'         => 'Revitalisasi Taman RW 02 Menjadi Ruang Terbuka Hijau Ramah Anak',
                'slug'          => 'revitalisasi-taman-rw-02',
                'content'       => '<p>Warga RW 02 Kelurahan Kali Baru kini memiliki ruang terbuka hijau baru yang asri. Lahan fasilitas umum yang sebelumnya kurang terawat, kini telah disulap menjadi taman bermain anak dan area olahraga lansia.</p><p>Peresmian taman ini dihadiri oleh tokoh masyarakat dan warga yang antusias. Diharapkan taman ini dapat menjadi pusat interaksi sosial yang positif bagi warga sekitar.</p>',
                'thumbnail'     => 'park_opening.jpg', 
                'category_id'   => 1,
                'author_id'     => $userId,
                'created_at'    => '2025-12-10 09:00:00',
            ],
            [
                'title'         => 'Siaga Banjir: Kelurahan Kali Baru Bentuk Tim Reaksi Cepat',
                'slug'          => 'siaga-banjir-tim-reaksi-cepat',
                'content'       => '<p>Menghadapi musim penghujan yang puncaknya diprediksi bulan Februari ini, Kelurahan Kali Baru telah mengukuhkan Tim Reaksi Cepat (TRC) Penanggulangan Bencana. Tim ini terdiri dari unsur Linmas, Karang Taruna, dan relawan warga.</p><p>"Fokus utama kami adalah evakuasi lansia dan balita jika debit air Kali Baru naik signifikan," ujar Koordinator TRC. Warga dihimbau untuk segera melapor ke posko siaga di kantor kelurahan jika melihat tanda-tanda luapan air.</p>',
                'thumbnail'     => 'flood_team.jpg', 
                'category_id'   => 1,
                'author_id'     => $userId,
                'created_at'    => '2026-01-24 14:00:00',
            ],
            [
                'title'         => 'Cegah DBD, Warga RW 05 Lakukan Fogging Mandiri',
                'slug'          => 'cegah-dbd-fogging-mandiri-rw05',
                'content'       => '<p>Warga RW 05 secara swadaya melakukan pengasapan (fogging) di lingkungan perumahan warga. Langkah ini diambil menyusul adanya laporan kasus Demam Berdarah Dengue (DBD) di kecamatan tetangga.</p><p>Selain fogging, kader Jumantik juga gencar melakukan pemeriksaan jentik nyamuk door-to-door untuk memastikan gerakan 3M Plus berjalan efektif di setiap rumah tangga.</p>',
                'thumbnail'     => 'fogging.jpg', 
                'category_id'   => 2,
                'author_id'     => $userId,
                'created_at'    => '2026-01-22 09:30:00',
            ],
            [
                'title'         => 'Kerja Bakti Massal Bersihkan Saluran Drainase Utama',
                'slug'          => 'kerja-bakti-bersihkan-drainase',
                'content'       => '<p>Ratusan warga Kali Baru turun ke jalan pada Minggu pagi untuk melakukan kerja bakti massal. Target utama kali ini adalah pengerukan sedimen dan sampah di saluran drainase utama sepanjang Jalan Rawa Bambu.</p><p>Kegiatan ini merupakan agenda rutin "Sabtu-Minggu Bersih" yang dicanangkan Lurah Kali Baru untuk menciptakan lingkungan yang sehat dan bebas genangan air.</p>',
                'thumbnail'     => 'gotong_royong.jpg', 
                'category_id'   => 2,
                'author_id'     => $userId,
                'created_at'    => '2026-01-18 07:00:00',
            ],
        ];

        $this->db->table('news_categories')->truncate();
        $this->db->table('news_categories')->insertBatch([
            ['id' => 1, 'name' => 'Berita Utama', 'slug' => 'berita-utama'],
            ['id' => 2, 'name' => 'Kegiatan Warga', 'slug' => 'kegiatan-warga'],
            ['id' => 3, 'name' => 'Pengumuman', 'slug' => 'pengumuman'],
        ]);

        $this->db->table('news')->truncate();
        foreach ($newsData as $news) {
            $this->db->table('news')->insert($news);
        }

        // 4. Tourism
        $tourismData = [
            [
                'name'        => 'Danau Indah Rawa Bambu',
                'slug'        => 'danau-indah-rawa-bambu',
                'description' => 'Danau buatan yang menjadi oase di tengah hiruk pikuk kota. Tempat yang cocok untuk bersantai sore hari, memancing, atau sekadar menikmati pemandangan matahari terbenam. Dilengkapi dengan jogging track dan spot foto sederhana.',
                'location'    => 'Jl. Rawa Bambu, Kali Baru',
                'thumbnail'   => 'lake.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Taman Harapan Baru FunPark',
                'slug'        => 'thb-funpark',
                'description' => 'Wahana rekreasi air keluarga yang terletak berbatasan dengan wilayah Kali Baru. Menawarkan kolam renang dengan berbagai seluncuran seru untuk anak-anak maupun dewasa. Fasilitas lengkap dan harga terjangkau menjadikannya favorit warga sekitar.',
                'location'    => 'Taman Harapan Baru, Medan Satria',
                'thumbnail'   => 'waterpark.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
             [
                'name'        => 'Kuliner Harapan Indah',
                'slug'        => 'kuliner-harapan-indah',
                'description' => 'Kawasan wisata kuliner malam yang menyajikan ragam makanan dari berbagai daerah. Mulai dari makanan tradisional hingga kekinian, tempat ini selalu ramai dikunjungi warga Kali Baru dan sekitarnya untuk wisata rasa.',
                'location'    => 'Kawasan Harapan Indah',
                'thumbnail'   => 'culinary.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tourism_spots')->truncate();
        foreach ($tourismData as $spot) {
            $this->db->table('tourism_spots')->insert($spot);
        }

        // 5. Services
        $servicesData = [
            [
                'name'        => 'Pembuatan KTP Elektronik',
                'icon'        => 'bi bi-person-vcard',
                'description' => 'Layanan perekaman dan pengurusan KTP Elektronik baru, hilang, atau rusak.',
            ],
            [
                'name'        => 'Kartu Keluarga (KK)',
                'icon'        => 'bi bi-people-fill',
                'description' => 'Permohonan pembuatan KK baru, penambahan anggota keluarga, atau perubahan data.',
            ],
            [
                'name'        => 'Surat Keterangan Usaha',
                'icon'        => 'bi bi-shop',
                'description' => 'Penerbitan surat keterangan untuk keperluan perizinan usaha mikro dan kecil (UMKM).',
            ],
            [
                'name'        => 'Surat Pindah Datang',
                'icon'        => 'bi bi-truck',
                'description' => 'Pengurusan administrasi kependudukan bagi warga yang pindah keluar atau masuk wilayah.',
            ],
            [
                'name'        => 'Pelayanan Akta Kelahiran',
                'icon'        => 'bi bi-file-earmark-text',
                'description' => 'Fasilitasi pembuatan akta kelahiran bagi bayi yang baru lahir.',
            ],
             [
                'name'        => 'Surat Keterangan Tidak Mampu',
                'icon'        => 'bi bi-file-text',
                'description' => 'Penerbitan SKTM untuk keperluan pendidikan, kesehatan, atau bantuan sosial.',
            ],
        ];

        $this->db->table('services')->truncate();
        foreach ($servicesData as $service) {
            $this->db->table('services')->insert($service);
        }
        
        // Enable FK Checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
