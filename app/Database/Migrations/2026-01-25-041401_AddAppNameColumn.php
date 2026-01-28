<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAppNameColumn extends Migration
{
    public function up()
    {
        $this->forge->addColumn('village_config', [
            'app_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'CMS DESA',
                'after'      => 'village_name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('village_config', 'app_name');
    }
}
