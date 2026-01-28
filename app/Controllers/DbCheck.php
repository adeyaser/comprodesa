<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DbCheck extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        try {
            echo "<h3>Database Connection</h3>";
            echo "Connected: " . ($db->connect() ? 'Yes' : 'No') . "<br>";

            echo "<h3>Tables</h3>";
            $tables = $db->listTables();
            echo "<pre>"; print_r($tables); echo "</pre>";

            if (!in_array('news', $tables)) {
                echo "<h1>CRITICAL: 'news' table does not exist!</h1>";
                return;
            }

            echo "<h3>News Table Columns</h3>";
            $cols = $db->getFieldNames('news');
            echo "<pre>"; print_r($cols); echo "</pre>";

            echo "<h3>Users Count</h3>";
            echo $db->table('users')->countAllResults();

            echo "<h3>News Categories Count</h3>";
            echo $db->table('news_categories')->countAllResults();
            
            echo "<h3>News Count</h3>";
            echo $db->table('news')->countAllResults();

            echo "<h3>Attempting Manual Insert</h3>";
            $data = [
                 'title' => 'Debug News ' . time(),
                 'slug'  => 'debug-news-' . time(),
                 'content' => 'Debug Content',
                 'category_id' => 1,
                 'author_id' => 1,
                 'created_at' => date('Y-m-d H:i:s'),
                 // 'status' => 'published' // Intentionally omitted
            ];
            
            // Raw Insert
            $sql = "INSERT INTO news (title, slug, content, category_id, author_id, created_at) VALUES (?, ?, ?, ?, ?, ?)";
            $db->query($sql, array_values($data));
            
            echo "<br>Insert execution finished. checking ID...";
            echo "<br>New ID: " . $db->insertID();

        } catch (\Throwable $e) {
            echo "<h1>EXCEPTION CAUGHT</h1>";
            echo $e->getMessage();
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
}
