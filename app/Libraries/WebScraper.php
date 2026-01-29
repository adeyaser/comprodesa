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

        $articles = $this->parseHtml($html, $source['source_name'], $url);

        // Fetch full content for each article (limit to save time/resources)
        foreach ($articles as &$article) {
            $article['full_content'] = $this->extractFullContent($article['url']);
        }

        return $articles;
    }

    private function extractFullContent($url)
    {
        $html = $this->fetchUrl($url);
        if (!$html) return null;

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        // List of common selectors for main article content
        $contentSelectors = [
            "//article",
            "//div[contains(@class, 'detail__body-text')]", // Detik
            "//div[contains(@class, 'read__content')]",    // Kompas
            "//div[contains(@class, 'article-content')]",  // General
            "//div[contains(@class, 'entry-content')]",    // Wordpress
            "//div[contains(@id, 'articleBody')]",        // General
            "//div[contains(@class, 'post-content')]"     // General
        ];

        foreach ($contentSelectors as $selector) {
            $nodes = $xpath->query($selector);
            if ($nodes->length > 0) {
                // Get the one with most text content
                $bestNode = null;
                $maxLen = 0;
                foreach ($nodes as $node) {
                    $len = strlen(trim($node->textContent));
                    if ($len > $maxLen) {
                        $maxLen = $len;
                        $bestNode = $node;
                    }
                }

                if ($bestNode) {
                    // Clean up script tags and other junk
                    $scripts = $xpath->query(".//script | .//style | .//iframe | .//ins | .//nav", $bestNode);
                    foreach ($scripts as $s) {
                        $s->parentNode->removeChild($s);
                    }
                    
                    // Return as HTML but clean up
                    $content = "";
                    $paragraphs = $xpath->query(".//p", $bestNode);
                    if ($paragraphs->length > 0) {
                        foreach ($paragraphs as $p) {
                            $text = trim($p->textContent);
                            if (strlen($text) > 20) {
                                $content .= "<p>" . htmlspecialchars($text) . "</p>";
                            }
                        }
                    } else {
                        $content = htmlspecialchars(trim($bestNode->textContent));
                    }
                    
                    return $content ?: null;
                }
            }
        }

        return null;
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
        
        // More comprehensive news query
        $query = "//h3/a | //h2/a | //h1/a | //a[contains(@class, 'title')] | //a[contains(@class, 'post-title')] | //a[contains(@id, 'title')]";
        
        $nodes = $xpath->query($query);
        
        foreach ($nodes as $node) {
            if (!($node instanceof \DOMElement)) continue;

            $title = trim($node->textContent);
            $link = $node->getAttribute('href');
            
            // Skip empty titles or obvious non-news links
            if (strlen($title) < 10 || empty($link) || $link == '#' || strpos($link, 'javascript') === 0) continue;

            $thumbnail = $this->extractThumbnail($xpath, $node);

            // Validation
            if (!empty($link)) {
                $articles[] = [
                    'source'    => $sourceName,
                    'title'     => $title,
                    'url'       => $this->resolveUrl($link, $baseUrl),
                    'thumbnail' => $thumbnail ? $this->resolveUrl($thumbnail, $baseUrl) : null,
                    'date'      => date('Y-m-d H:i:s') 
                ];
            }
            
            // Limit to more items per source to increase chance of matching keywords
            if (count($articles) >= 15) break; 
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
