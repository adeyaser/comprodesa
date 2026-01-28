<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NewsModel;
use App\Models\CategoryModel;

class News extends BaseController
{
    protected $newsModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Berita',
            'user'  => session()->get('full_name'),
            'news'  => $this->newsModel->select('news.*, news_categories.name as category_name')
                                      ->join('news_categories', 'news_categories.id = news.category_id', 'left')
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll(),
        ];
        return view('admin/news/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Berita Baru',
            'user'       => session()->get('full_name'),
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('admin/news/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[5]',
            'category_id' => 'required',
            'content'     => 'required',
            'thumbnail'   => 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $fileThumbnail = $this->request->getFile('thumbnail');
        $newName = $fileThumbnail->getRandomName();
        $fileThumbnail->move('uploads/news', $newName);

        $this->newsModel->save([
            'category_id' => $this->request->getPost('category_id'),
            'title'       => $this->request->getPost('title'),
            'slug'        => url_title($this->request->getPost('title'), '-', true),
            'content'     => $this->request->getPost('content'),
            'thumbnail'   => $newName,
            'author_id'   => session()->get('id'),
        ]);

        return redirect()->to('admin/news')->with('success', 'Berita berhasil diterbitkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Berita',
            'user'       => session()->get('full_name'),
            'news'       => $this->newsModel->find($id),
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('admin/news/edit', $data);
    }

    public function update($id)
    {
        $news = $this->newsModel->find($id);
        
        $data = [
            'id'          => $id,
            'category_id' => $this->request->getPost('category_id'),
            'title'       => $this->request->getPost('title'),
            'slug'        => url_title($this->request->getPost('title'), '-', true),
            'content'     => $this->request->getPost('content'),
        ];

        $fileThumbnail = $this->request->getFile('thumbnail');
        if ($fileThumbnail && $fileThumbnail->isValid() && !$fileThumbnail->hasMoved()) {
            // Delete old thumbnail
            if ($news['thumbnail'] && file_exists('uploads/news/' . $news['thumbnail'])) {
                unlink('uploads/news/' . $news['thumbnail']);
            }
            $newName = $fileThumbnail->getRandomName();
            $fileThumbnail->move('uploads/news', $newName);
            $data['thumbnail'] = $newName;
        }

        $this->newsModel->save($data);

        return redirect()->to('admin/news')->with('success', 'Berita berhasil diperbarui.');
    }

    public function delete($id)
    {
        $news = $this->newsModel->find($id);
        if ($news['thumbnail'] && file_exists('uploads/news/' . $news['thumbnail'])) {
            unlink('uploads/news/' . $news['thumbnail']);
        }
        $this->newsModel->delete($id);
        return redirect()->to('admin/news')->with('success', 'Berita berhasil dihapus.');
    }
}
