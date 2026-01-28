<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixThumbnailsSeeder extends Seeder
{
    public function run()
    {
        $this->db->query("UPDATE news SET thumbnail = REPLACE(thumbnail, '.jpg', '.svg') WHERE thumbnail LIKE '%.jpg'");
        $this->db->query("DELETE FROM news WHERE thumbnail IS NULL OR thumbnail = ''");
        echo "Cleaned up thumbnails.";
    }
}
