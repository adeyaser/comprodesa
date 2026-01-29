<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Scraper extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title'   => 'Manajemen Web Scraper',
            'user'    => session()->get('full_name'),
            'sources' => $this->db->table('scraping_sources')->get()->getResultArray()
        ];
        return view('admin/scraper/index', $data);
    }

    public function create()
    {
        $data = [
            'source_name' => $this->request->getPost('source_name'),
            'url'         => $this->request->getPost('url'),
            'type'        => $this->request->getPost('type'),
            'status'      => 'active',
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        $this->db->table('scraping_sources')->insert($data);
        return redirect()->back()->with('success', 'Sumber berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $this->db->table('scraping_sources')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Sumber berhasil dihapus.');
    }

    public function toggle($id)
    {
        $source = $this->db->table('scraping_sources')->where('id', $id)->get()->getRowArray();
        $newStatus = ($source['status'] == 'active') ? 'inactive' : 'active';
        $this->db->table('scraping_sources')->where('id', $id)->update(['status' => $newStatus]);
        return redirect()->back()->with('success', 'Status sumber berhasil diubah.');
    }

    public function refresh()
    {
        cache()->delete('external_news_v3');
        return redirect()->to(base_url('news?refresh=true'))->with('success', 'Cache dibersihkan, memulai scraping ulang...');
    }

    /**
     * Fitur untuk menjalankan migrasi database via web
     * Berguna jika hosting tidak memiliki akses SSH/Terminal
     */
    public function migrate()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
            return redirect()->back()->with('success', 'Sinkronisasi database (Migrasi) berhasil dijalankan.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal migrasi: ' . $e->getMessage());
        }
    }

    /**
     * URL untuk Cron Job (Akses via browser atau wget)
     * Limitasi: Menggunakan Secret Key untuk keamanan
     */
    public function runAutoScrape()
    {
        // Simple security key check
        $key = $this->request->getGet('key');
        if ($key !== 'kalibaru_scrape_2026') {
            return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Run the command logic
        $newsModel = new \App\Models\NewsModel();
        $scraper = new \App\Libraries\WebScraper();
        $sources = $this->db->table('scraping_sources')->where('status', 'active')->get()->getResultArray();
        
        $newItemsCount = 0;
        $logs = [];

        foreach ($sources as $source) {
            try {
                $items = $scraper->scrap($source);
                foreach ($items as $item) {
                    $urlHash = sha1($item['url']);
                    $exists = $this->db->table('scraping_logs')->where('url_hash', $urlHash)->countAllResults();
                    
                    if ($exists === 0) {
                        $slug = mb_url_title($item['title'], '-', true);
                        $data = [
                            'category_id'  => 1,
                            'title'        => $item['title'],
                            'slug'         => $slug . '-' . substr($urlHash, 0, 5),
                            'content'      => $item['full_content'] ?: 'Berita disadur dari ' . $item['source'],
                            'thumbnail'    => $item['thumbnail'],
                            'author_id'    => 1,
                            'original_url' => $item['url'],
                            'source_name'  => $item['source'],
                            'is_external'  => 1,
                            'created_at'   => date('Y-m-d H:i:s'),
                            'updated_at'   => date('Y-m-d H:i:s')
                        ];
                        $newsModel->insert($data);
                        $this->db->table('scraping_logs')->insert([
                            'url_hash'   => $urlHash,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                        $newItemsCount++;
                    }
                }
            } catch (\Exception $e) {
                $logs[] = "Error on " . $source['source_name'] . ": " . $e->getMessage();
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'new_items' => $newItemsCount,
            'errors' => $logs,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
}
