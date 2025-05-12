<?php

namespace App\Controllers;

use App\Models\M_user;

class login extends BaseController
{
    public function halaman_login()
    {
        return view('login');
    }

    public function aksi_login()
    {
        $username = $this->request->getPost('usn');
        $password = $this->request->getPost('pswd');
        $recaptcha_response = $this->request->getPost('g-recaptcha-response');
        $math_answer = $this->request->getPost('math_answer');
        $correct_answer = $this->request->getPost('correct_answer');

        $connected = @fsockopen("www.google.com", 80);
        
        if ($connected) {
            fclose($connected);

            $recaptcha_secret = "6LcNvAsrAAAAAI8Nvq9CniGxm_wZyonH5OrjuJCc"; 
            $verify_url = "https://www.google.com/recaptcha/api/siteverify";
            $response = file_get_contents($verify_url . "?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response);
            $response_keys = json_decode($response, true);

            if (!$response_keys["success"]) {
                echo "reCAPTCHA verification failed. Please try again.";
                exit();
            }
        } else {
            if ($math_answer === null || $correct_answer === null || (int)$math_answer !== (int)$correct_answer) {
                echo "Verifikasi matematika salah. Coba lagi.";
                exit();
            }
        }

        $M_user = new \App\Models\M_user(); 
        $user = $M_user->where('username', $username)->first();
        
        if (!$user) {
            echo "Username tidak ditemukan!";
            exit();
        }
        
        if (md5($password) !== $user['password']) {
            echo "Password salah!";
            exit();
        }
        
        session()->regenerate();
        $sessionData = [
            'id_user'       => (int) $user['id_user'],
            'usn'           => $user['username'],
            'level'         => (int) $user['level'],
            'nama_user'     => $user['nama_user'],
            'isLoggedIn'    => true,
            'last_activity' => time()
        ];
        session()->set($sessionData);
        
        $this->logActivity("Login ke sistem");
        
        return redirect()->to('home/dashboard');
    }
}