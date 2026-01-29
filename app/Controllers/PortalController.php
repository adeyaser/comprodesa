<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PortalController extends BaseController
{
    protected $configModel;
    protected $newsModel;
    protected $tourismModel;
    protected $serviceModel;
    protected $galleryModel;

    public function __construct()
    {
        $this->configModel = new \App\Models\ConfigModel();
        $this->newsModel = new \App\Models\NewsModel();
        $this->tourismModel = new \App\Models\TourismModel();
        $this->serviceModel = new \App\Models\ServiceModel();
        $this->galleryModel = new \App\Models\GalleryModel();
    }

    private function getCommonData($title)
    {
        return [
            'title'  => $title,
            'config' => $this->configModel->first(),
        ];
    }

    public function news()
    {
        $data = $this->getCommonData('Berita Desa');
        
        // Filter by category if needed or search
        $this->newsModel->select('news.*, news_categories.name as category_name')
                        ->join('news_categories', 'news_categories.id = news.category_id', 'left');
        
        $category = $this->request->getGet('category');
        if ($category) {
            $this->newsModel->where('news_categories.slug', $category);
        }

        $search = $this->request->getGet('q');
        if ($search) {
            $this->newsModel->groupStart()
                            ->like('news.title', $search)
                            ->orLike('news.content', $search)
                            ->groupEnd();
        }

        $data['news'] = $this->newsModel->orderBy('news.created_at', 'DESC')
                                       ->paginate(9, 'news');
        $data['pager'] = $this->newsModel->pager;
        
        if ($this->request->isAJAX()) {
            return view('portal/news/_list_items', $data);
        }

        return view('portal/news/index', $data);
    }

    public function newsDetail($slug)
    {
        $news = $this->newsModel->select('news.*, news_categories.name as category_name, users.full_name as author_name')
                                ->join('news_categories', 'news_categories.id = news.category_id')
                                ->join('users', 'users.id = news.author_id')
                                ->where('news.slug', $slug)
                                ->first();
        if (!$news) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = $this->getCommonData($news['title']);
        $data['news'] = $news;
        $data['recent_news'] = $this->newsModel->where('id !=', $news['id'])->orderBy('created_at', 'DESC')->limit(5)->findAll();
        
        // Custom SEO for Detail
        $data['meta_description'] = substr(strip_tags($news['content']), 0, 160);
        $data['og_type'] = 'article';
        
        return view('portal/news/detail', $data);
    }

    public function tourism()
    {
        $data = $this->getCommonData('Destinasi Wisata');
        $data['spots'] = $this->tourismModel->findAll();
        return view('portal/tourism/index', $data);
    }

    public function tourismDetail($slug)
    {
        $spot = $this->tourismModel->where('slug', $slug)->first();
        if (!$spot) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = $this->getCommonData($spot['name']);
        $data['spot'] = $spot;
        $data['gallery'] = $this->galleryModel->where('spot_id', $spot['id'])->findAll();
        
        // Custom SEO for Detail
        $data['meta_description'] = substr(strip_tags($spot['description']), 0, 160);
        
        return view('portal/tourism/detail', $data);
    }

    public function profile()
    {
        $data = $this->getCommonData('Profil Desa');
        return view('portal/profile', $data);
    }

    public function services()
    {
        $data = $this->getCommonData('Layanan Desa');
        $data['services'] = $this->serviceModel->findAll();
        return view('portal/services', $data);
    }

    public function sitemap()
    {
        $news = $this->newsModel->findAll();
        $tourism = $this->tourismModel->findAll();

        $data = [
            'news'    => $news,
            'tourism' => $tourism,
        ];

        return $this->response
                    ->setStatusCode(200)
                    ->setContentType('text/xml')
                    ->setBody(view('portal/sitemap', $data));
    }
}
