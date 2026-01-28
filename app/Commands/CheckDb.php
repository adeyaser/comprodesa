<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckDb extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:check';
    protected $description = 'Checks database content.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        CLI::write('Checking News Table...', 'yellow');
        $count = $db->table('news')->countAllResults();
        CLI::write("News Count: $count", 'green');
        
        if ($count == 0) {
            CLI::write('Attempting Manual Insert via CLI...', 'yellow');
             $data = [
                 'title' => 'CLI Debug News',
                 'slug'  => 'cli-debug-news-' . time(),
                 'content' => 'Debug Content',
                 'category_id' => 1,
                 'author_id' => 1,
                 'created_at' => date('Y-m-d H:i:s'),
            ];
            
            try {
                $db->table('news')->insert($data);
                CLI::write('Insert Success! ID: ' . $db->insertID(), 'green');
            } catch (\Throwable $e) {
                CLI::error('Insert Failed: ' . $e->getMessage());
            }
        }
        
        $rows = $db->table('news')->get()->getResultArray();
        print_r($rows);
    }
}
