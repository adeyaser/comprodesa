<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Services extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Layanan Desa',
            'user'     => session()->get('full_name'),
            'services' => $this->serviceModel->findAll(),
        ];
        return view('admin/services/index', $data);
    }

    public function store()
    {
        $this->serviceModel->save([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
        ]);

        return redirect()->to('admin/services')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update($id)
    {
        $this->serviceModel->save([
            'id'          => $id,
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
        ]);

        return redirect()->to('admin/services')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->serviceModel->delete($id);
        return redirect()->to('admin/services')->with('success', 'Layanan berhasil dihapus.');
    }
}
