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
        
        // Try both dot and underscore notation for compatibility
        $secretKey = env('turnstile.secret_key') ?? env('turnstile_secret_key');

        if (empty($secretKey)) {
            // Fallback for some hosting that doesn't load .env properly into env()
            $secretKey = $_ENV['turnstile.secret_key'] ?? $_ENV['turnstile_secret_key'] ?? '';
        }

        if (empty($secretKey)) {
            log_message('error', 'Turnstile Secret Key is missing in .env or environment');
            return redirect()->back()->with('error', 'Konfigurasi keamanan tidak lengkap (Missing Secret Key). Silakan hubungi pengelola.')->withInput();
        }
        
        $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'secret'   => $secretKey,
            'response' => $turnstileResponse,
            // remoteip is optional and can cause issues behind proxies/Cloudflare
        ]);
        
        // Add timeout to prevent hanging
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        // Some shared hosting need this to handle HTTPS verification correctly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        
        // Fallback for localhost or environments with SSL cert issues
        if (strpos(base_url(), 'localhost') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $outcome = json_decode($response, true);
        curl_close($ch);

        if (!$outcome || !isset($outcome['success']) || !$outcome['success']) {
            // Log very detailed error for the developer
            log_message('error', 'Turnstile verification failed. Response: ' . ($response ?: 'Empty') . ' | Curl Error: ' . ($error ?: 'None'));
            return redirect()->back()->with('error', 'Verifikasi keamanan (Turnstile) gagal. Periksa koneksi server ke Cloudflare atau pengaturan kuncinya.')->withInput();
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
