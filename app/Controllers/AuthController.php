<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();

        // Verify Cloudflare Turnstile
        $turnstileResponse = $this->request->getPost('cf-turnstile-response');
        $secretKey = env('turnstile.secret_key');
        
        $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'secret'   => $secretKey,
            'response' => $turnstileResponse,
            'remoteip' => $this->request->getIPAddress(),
        ]);
        
        $outcome = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (!$outcome || !$outcome['success']) {
            return redirect()->back()->with('error', 'Verifikasi keamanan (Turnstile) gagal. Silakan coba lagi.')->withInput();
        }

        $model = new \App\Models\UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'isLoggedIn' => true,
                ]);
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
