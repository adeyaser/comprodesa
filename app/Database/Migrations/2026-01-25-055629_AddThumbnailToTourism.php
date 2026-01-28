<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThumbnailToTourism extends Migration
{
    public function up()
    {
        $fields = [
            'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'location'],
        ];
        $this->forge->addColumn('tourism_spots', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tourism_spots', 'thumbnail');
    }
}
