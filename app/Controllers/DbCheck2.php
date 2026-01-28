<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DbCheck2 extends BaseController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            if ($db->connect()) {
                echo "<h3>Database Connection</h3>";
                echo "Connected successfully to: " . $db->getDatabase();
            }

            echo "<h3>Tables</h3>";
            echo "<pre>"; print_r($db->listTables()); echo "</pre>";

            echo "<h3>News with Empty Thumbnails</h3>";
            $query = $db->query("SELECT id, title, thumbnail FROM news WHERE thumbnail IS NULL OR thumbnail = ''");
            $rows = $query->getResultArray();
            echo "<pre>"; print_r($rows); echo "</pre>";

            echo "<h3>Users Count</h3>";
            echo $db->table('users')->countAllResults();

            return;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function cleanup()
    {
        $db = \Config\Database::connect();
        $db->table('news')->where('thumbnail', '')->orWhere('thumbnail', null)->delete();
        echo "Deleted news with empty thumbnails.";
    }
}
