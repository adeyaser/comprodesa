<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSourceToNews extends Migration
{
    public function up()
    {
        $this->forge->addColumn('news', [
            'original_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'slug'
            ],
            'source_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'original_url'
            ],
            'is_external' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'source_name'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('news', ['original_url', 'source_name', 'is_external']);
    }
}
