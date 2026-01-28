<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $configModel = new \App\Models\ConfigModel();
        $newsModel = new \App\Models\NewsModel();
        $tourismModel = new \App\Models\TourismModel();

        $data = [
            'config'  => $configModel->first(),
            'latest_news' => $newsModel->select('news.*, news_categories.name as category_name')
                                   ->join('news_categories', 'news_categories.id = news.category_id')
                                   ->orderBy('created_at', 'DESC')
                                   ->limit(3)
                                   ->findAll(),
            'featured_tourism' => $tourismModel->limit(4)->findAll(), // Fixed variable name
            'services' => (new \App\Models\ServiceModel())->findAll(),
        ];

        return view('home', $data);
    }
}
