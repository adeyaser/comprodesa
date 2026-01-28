<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TourismModel;
use App\Models\GalleryModel;

class Tourism extends BaseController
{
    protected $tourismModel;
    protected $galleryModel;

    public function __construct()
    {
        $this->tourismModel = new TourismModel();
        $this->galleryModel = new GalleryModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Destinasi Wisata',
            'user'    => session()->get('full_name'),
            'spots'   => $this->tourismModel->findAll(),
        ];
        return view('admin/tourism/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Destinasi Wisata',
            'user'  => session()->get('full_name'),
        ];
        return view('admin/tourism/create', $data);
    }

    public function store()
    {
        $this->tourismModel->save([
            'name'        => $this->request->getPost('name'),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'description' => $this->request->getPost('description'),
            'location'    => $this->request->getPost('location'),
        ]);

        return redirect()->to('admin/tourism')->with('success', 'Destinasi wisata berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'   => 'Edit Destinasi Wisata',
            'user'    => session()->get('full_name'),
            'spot'    => $this->tourismModel->find($id),
            'gallery' => $this->galleryModel->where('spot_id', $id)->findAll(),
        ];
        return view('admin/tourism/edit', $data);
    }

    public function update($id)
    {
        $this->tourismModel->save([
            'id'          => $id,
            'name'        => $this->request->getPost('name'),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'description' => $this->request->getPost('description'),
            'location'    => $this->request->getPost('location'),
        ]);

        return redirect()->to('admin/tourism')->with('success', 'Destinasi wisata berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Delete gallery images
        $gallery = $this->galleryModel->where('spot_id', $id)->findAll();
        foreach ($gallery as $item) {
            if (file_exists('uploads/gallery/' . $item['image'])) {
                unlink('uploads/gallery/' . $item['image']);
            }
        }
        $this->galleryModel->where('spot_id', $id)->delete();
        $this->tourismModel->delete($id);

        return redirect()->to('admin/tourism')->with('success', 'Destinasi wisata berhasil dihapus.');
    }

    // Gallery Management
    public function uploadGallery($spot_id)
    {
        $files = $this->request->getFileMultiple('gallery_files');
        
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/gallery', $newName);
                
                $this->galleryModel->save([
                    'spot_id' => $spot_id,
                    'image'   => $newName,
                    'caption' => $this->request->getPost('caption') ?? '',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Foto galeri berhasil diunggah.');
    }

    public function deleteGallery($id)
    {
        $item = $this->galleryModel->find($id);
        if ($item && file_exists('uploads/gallery/' . $item['image'])) {
            unlink('uploads/gallery/' . $item['image']);
        }
        $this->galleryModel->delete($id);
        return redirect()->back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}
