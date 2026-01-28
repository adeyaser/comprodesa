<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ProbeScrape extends Controller
{
    public function index()
    {
        $url = 'https://gobekasi.id/lokal-daerah/kota-bekasi/';
        
        // Use stream context to fake user agent
        $options = [
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
            ]
        ];
        $context = stream_context_create($options);
        
        $html = @file_get_contents($url, false, $context);
        
        if ($html === false) {
            echo "Failed to fetch URL";
            return;
        }

        echo "<h1>Raw HTML Snippet</h1>";
        echo "<textarea style='width:100%; height:500px;'>";
        echo htmlspecialchars(substr($html, 0, 10000)); // First 10k chars
        echo "</textarea>";
    }
}
