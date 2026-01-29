<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScrapingLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'url_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'unique'     => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('scraping_logs');
    }

    public function down()
    {
        $this->forge->dropTable('scraping_logs');
    }
}
