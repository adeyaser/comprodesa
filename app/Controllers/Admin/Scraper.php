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
}
