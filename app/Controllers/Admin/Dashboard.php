<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'user' => session()->get('full_name'),
        ];
        return view('admin/dashboard', $data);
    }
}
