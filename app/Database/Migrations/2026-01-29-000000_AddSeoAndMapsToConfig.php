<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSeoAndMapsToConfig extends Migration
{
    public function up()
    {
        $fields = [
            'meta_description' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'village_mission'
            ],
            'meta_keywords' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'meta_description'
            ],
            'google_maps' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'meta_keywords'
            ],
        ];
        $this->forge->addColumn('village_config', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('village_config', ['meta_description', 'meta_keywords', 'google_maps']);
    }
}
