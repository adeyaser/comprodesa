<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAnalyticsToConfig extends Migration
{
    public function up()
    {
        $fields = [
            'google_analytics' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'google_maps',
            ],
        ];
        $this->forge->addColumn('village_config', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('village_config', 'google_analytics');
    }
}
