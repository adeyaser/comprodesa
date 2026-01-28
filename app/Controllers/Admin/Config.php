<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConfigModel;

class Config extends BaseController
{
    protected $configModel;

    public function __construct()
    {
        $this->configModel = new ConfigModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengaturan Profil Desa',
            'user'  => session()->get('full_name'),
            'config' => $this->configModel->first(),
        ];
        return view('admin/config/index', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $data = [
            'village_name'    => $this->request->getPost('village_name'),
            'app_name'        => $this->request->getPost('app_name'),
            'village_address' => $this->request->getPost('village_address'),
            'village_phone'   => $this->request->getPost('village_phone'),
            'village_email'   => $this->request->getPost('village_email'),
            'village_history' => $this->request->getPost('village_history'),
            'village_vision'  => $this->request->getPost('village_vision'),
            'village_mission' => $this->request->getPost('village_mission'),
        ];

        // Handle Logo Upload
        $fileLogo = $this->request->getFile('village_logo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $newName = $fileLogo->getRandomName();
            $fileLogo->move('uploads/logo', $newName);
            $data['village_logo'] = $newName;
        }

        if ($this->configModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Profil desa berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui profil desa.');
        }
    }
}
