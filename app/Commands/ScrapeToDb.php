<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ScrapeToDb extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Automation';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'scrape:run';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Scrapes external news and saves them to the database.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'scrape:run';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $newsModel = new \App\Models\NewsModel();
        $scraper = new \App\Libraries\WebScraper();
        
        $sources = $db->table('scraping_sources')->where('status', 'active')->get()->getResultArray();
        
        CLI::write('Starting scrape process...', 'yellow');
        
        $newItemsCount = 0;
        
        foreach ($sources as $source) {
            CLI::write('Scraping: ' . $source['source_name'], 'cyan');
            
            $items = $scraper->scrap($source);
            
            foreach ($items as $item) {
                $urlHash = sha1($item['url']);
                
                // Check if already exist in logs
                $exists = $db->table('scraping_logs')->where('url_hash', $urlHash)->countAllResults();
                
                if ($exists === 0) {
                    // Try to generate a clean slug
                    $slug = mb_url_title($item['title'], '-', true);
                    
                        // Add to news table
                        $content = $item['full_content'] ?: 'Berita ini disadur dari ' . $item['source'] . '. Silakan baca selengkapnya di sumber asli.';
                        
                        $data = [
                            'category_id'  => 1, // Default category (Berita)
                            'title'        => $item['title'],
                            'slug'         => $slug . '-' . substr($urlHash, 0, 5),
                            'content'      => $content,
                            'thumbnail'    => $item['thumbnail'],
                            'author_id'    => 1, // System user
                            'original_url' => $item['url'],
                            'source_name'  => $item['source'],
                            'is_external'  => 1,
                            'created_at'   => date('Y-m-d H:i:s'),
                            'updated_at'   => date('Y-m-d H:i:s')
                        ];
                    
                    try {
                        $newsModel->insert($data);
                        
                        // Log it
                        $db->table('scraping_logs')->insert([
                            'url_hash'   => $urlHash,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                        
                        $newItemsCount++;
                        CLI::write('  [NEW] ' . $item['title'], 'green');
                    } catch (\Exception $e) {
                        CLI::error('  [ERR] ' . $e->getMessage());
                    }
                }
            }
        }
        
        CLI::write('Scrape finished. Total new items: ' . $newItemsCount, 'yellow');
    }
}
