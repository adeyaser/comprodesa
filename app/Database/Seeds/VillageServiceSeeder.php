<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VillageServiceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Administrasi Kependudukan',
                'description' => 'Layanan pengurusan dokumen kependudukan seperti Kartu Tanda Penduduk (e-KTP), Kartu Keluarga (KK), Akta Kelahiran, dan Akta Kematian. Kami melayani perekaman data dan penerbitan dokumen baru maupun pembaruan data.',
                'icon'        => 'bi-person-vcard'
            ],
            [
                'name'        => 'Surat Pengantar SKCK',
                'description' => 'Layanan penerbitan surat pengantar dari kelurahan sebagai syarat utama pembuatan Surat Keterangan Catatan Kepolisian (SKCK) di Polsek atau Polres setempat. Syarat: Pengantar RT/RW, fotokopi KTP dan KK.',
                'icon'        => 'bi-shield-check'
            ],
            [
                'name'        => 'Surat Keterangan Tidak Mampu (SKTM)',
                'description' => 'Fasilitas bagi warga kurang mampu untuk mendapatkan keringanan biaya pendidikan, kesehatan, atau bantuan sosial lainnya. Proses verifikasi dilakukan secara ketat melalui RT/RW dan survei lapangan.',
                'icon'        => 'bi-heart-pulse'
            ],
            [
                'name'        => 'Surat Keterangan Domisili',
                'description' => 'Layanan pembuatan surat keterangan domisili untuk keperluan usaha, tempat tinggal sementara, atau persyaratan administrasi perbankan dan sekolah. Proses cepat dengan validasi data yang akurat.',
                'icon'        => 'bi-house-check'
            ],
            [
                'name'        => 'Pelayanan PBB & Pajak Daerah',
                'description' => 'Menerima konsultasi dan bantuan terkait pembayaran Pajak Bumi dan Bangunan (PBB) serta pajak daerah lainnya. Kami juga melayani pencetakan SPPT PBB tahunan bagi wajib pajak.',
                'icon'        => 'bi-receipt'
            ],
            [
                'name'        => 'Surat Keterangan Usaha (SKU)',
                'description' => 'Fasilitas bagi pelaku UMKM di Kelurahan Kali Baru/Medan Satria untuk mendapatkan legalitas keterangan usaha sebagai syarat pengajuan modal usaha (KUR) atau izin operasional lainnya.',
                'icon'        => 'bi-shop'
            ],
            [
                'name'        => 'Layanan Pengaduan Warga',
                'description' => 'Saluran resmi untuk menyampaikan aspirasi, keluhan infrastruktur (jalan rusak, lampu mati, banjir), atau gangguan ketertiban umum. Laporan akan ditindaklanjuti oleh petugas terkait atau diteruskan ke instansi berwenang.',
                'icon'        => 'bi-megaphone'
            ],
            [
                'name'        => 'Rekomendasi Nikah (Numpang Nikah)',
                'description' => 'Layanan administrasi bagi warga yang akan melangsungkan pernikahan, baik di dalam maupun di luar wilayah domisili.',
                'icon'        => 'bi-gender-ambiguous'
            ]
        ];

        $this->db->table('village_services')->truncate();
        $this->db->table('village_services')->insertBatch($data);
    }
}
