<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DownloadImages extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'images:download';
    protected $description = 'Downloads placeholder images for news.';

    public function run(array $params)
    {
        $targetDir = FCPATH . 'uploads/news/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $images = [
            // News
            'flood_release.jpg' => 'Banjir',
            'culture_fest.jpg'  => 'Budaya',
            'cleanup.jpg'       => 'Pembersihan',
            'park_opening.jpg'  => 'Taman',
            'flood_team.jpg'    => 'Tim Siaga',
            'fogging.jpg'       => 'Fogging',
            'gotong_royong.jpg' => 'Gotong Royong',
            
            // Tourism
            'danau_duta.svg'    => 'Danau Duta',
            'kuliner_hi.svg'    => 'Kuliner HI',
            'thb_pool.svg'      => 'Kolam Renang',
            'ikan_hias.svg'     => 'Ikan Hias',
            'danau_kalibaru.svg'=> 'Danau Kali Baru',
            
            // Gallery (Dummy loop for efficiency handled below ideally, but let's add few)
            'danau_duta-gal-1.svg' => 'Galeri Danau',
            'danau_duta-gal-2.svg' => 'Galeri Danau',
            'danau_duta-gal-3.svg' => 'Galeri Danau',
            
            'wisata-kuliner-harapan-indah-gal-1.svg' => 'Galeri Kuliner', // slug based names from seeder
            'wisata-kuliner-harapan-indah-gal-2.svg' => 'Galeri Kuliner', 
            
            'kolam-renang-thb-gal-1.svg' => 'Galeri THB',
            
            'sentra-ikan-hias-medan-satria-gal-1.svg' => 'Galeri Ikan',
        ];

        // Ensure gallery directory exists? Wait, seeder uses same uploads? 
        // Tourism seeder usually uses public/uploads/tourism/ ?
        // Let's check Tourism view or model, usually consistent. 
        // Assuming public/uploads/tourism/ for now.

        foreach ($images as $filename => $text) {
             $filename = str_replace('.jpg', '.svg', $filename);
             CLI::write("Creating SVG for $filename...", 'yellow');
             
             // Determine Directory
             $useDir = $targetDir; // Default news
             if (strpos($filename, 'danau') !== false || strpos($filename, 'kuliner') !== false || strpos($filename, 'thb') !== false || strpos($filename, 'ikan') !== false) {
                 $useDir = FCPATH . 'uploads/tourism/';
                 if (!is_dir($useDir)) mkdir($useDir, 0777, true);
             }
             
             // Create a simple SVG placeholder
             $svg = '<svg width="800" height="400" xmlns="http://www.w3.org/2000/svg">' .
                    '<rect width="100%" height="100%" fill="#e0f7fa"/>' .
                    '<rect width="100%" height="100%" fill="none" stroke="#26c6da" stroke-width="4"/>' .
                    '<text x="50%" y="50%" font-family="Arial" font-size="30" fill="#006064" dominant-baseline="middle" text-anchor="middle" font-weight="bold">' . $text . '</text>' .
                    '</svg>';
            
             file_put_contents($useDir . $filename, $svg);
             CLI::write("Created SVG in " . basename($useDir), 'green');
        }
    }
}
