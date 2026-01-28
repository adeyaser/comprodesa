<?php

namespace App\Libraries;

class WebScraper
{
    private $client;

    public function __construct() {
        // Simple file_get_contents or curl wrapper
    }

    public function scrap($source)
    {
        $url = $source['url'];
        $html = $this->fetchUrl($url);
        
        if (!$html) return [];

        return $this->parseHtml($html, $source['source_name'], $url);
    }

    private function fetchUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // Generic User Agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $output = curl_exec($ch);
        curl_close($ch);
        
        return $output;
    }

    private function parseHtml($html, $sourceName, $baseUrl)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        $articles = [];
        
        $query = "//h3/a | //h2/a | //div[contains(@class, 'post-title')]/a | //h1[contains(@class, 'post-title')]/a";
        
        $nodes = $xpath->query($query);
        
        foreach ($nodes as $node) {
            if (!($node instanceof \DOMElement)) continue;

            $title = trim($node->textContent);
            $link = $node->getAttribute('href');
            
            $thumbnail = $this->extractThumbnail($xpath, $node);

            // Validation
            if (strlen($title) > 5 && !empty($link)) {
                $articles[] = [
                    'source'    => $sourceName,
                    'title'     => $title,
                    'url'       => $this->resolveUrl($link, $baseUrl),
                    'thumbnail' => $thumbnail ? $this->resolveUrl($thumbnail, $baseUrl) : null,
                    'date'      => date('Y-m-d H:i:s') 
                ];
            }
            
            if (count($articles) >= 5) break; 
        }

        return $articles;
    }

    private function extractThumbnail($xpath, $node)
    {
        $parent = $node->parentNode;
        for ($i = 0; $i < 3; $i++) {
            if (!$parent) break;
            
            $imgs = $xpath->query(".//img", $parent);
            if ($imgs->length > 0) {
                return $imgs->item(0)->getAttribute('src') ?: $imgs->item(0)->getAttribute('data-src');
            }
            $parent = $parent->parentNode;
        }
        return null;
    }

    private function resolveUrl($url, $baseUrl)
    {
        if (empty($url)) return null;

        // Already absolute
        if (strpos($url, 'http') === 0) return $url;

        // Protocol relative //example.com/img.jpg
        if (substr($url, 0, 2) === '//') {
            return 'https:' . $url; // Assume https
        }

        $parsedBase = parse_url($baseUrl);
        $root = $parsedBase['scheme'] . '://' . $parsedBase['host'];

        // Root relative /assets/img.jpg
        if ($url[0] === '/') {
            return $root . $url;
        }

        // Path relative fallback
        $cleanBase = strtok($baseUrl, '?');
        return rtrim($cleanBase, '/') . '/' . $url;
    }
}
