<?php

namespace App\Controllers;

use App\Models\M_user;

class User extends BaseController
{  
    public function tabel_user()
    {
        $this->logActivity("Mengakses Tabel User");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_user = new M_user(); 
        $data = [
            'title' => 'Data User',
            'showWelcome' => false, 
            'user' => $M_user->getUser(),
        ];

        return view('user', $data);
    }

    public function detail_user($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_user = new M_user();

        $logModel->saveLog($user_id, "id_user={$user_id} mencoba mengakses detail user ID {$id}", $ip_address);

        $user = $M_user->getUserById($id);

        if (!$user) {
            $logModel->saveLog($user_id, "id_user={$user_id} tidak menemukan data user ID {$id}", $ip_address);
            return redirect()->to(base_url('user/tabel_user'))->with('error', 'Data user tidak ditemukan.');
        }

        $logModel->saveLog($user_id, "id_user={$user_id} berhasil melihat detail user ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail User',
            'user' => $user
        ];

        return view('detail_user', $data);
    }

    public function edit_user($id)
    {   
        $M_user = new M_user();
        $wece = ['id_user' => $id];
    
        $data = [
            "password" => md5('1111') 
        ];

        $M_user->edit('user', $data, $wece);

        $db = \Config\Database::connect();
        $user = $db->table('user')->where('id_user', $id)->get()->getRowArray();

        if ($user) {
            $this->logActivity("Reset password untuk user: " . $user['email']);
        } else {
            $this->logActivity("Reset password gagal, user dengan ID $id tidak ditemukan.");
        }

        return redirect()->to('user/tabel_user');
    }

    public function dihapus_user()
    {
        $this->logActivity("Mengakses Tabel Data User yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_user = new M_user();
        $data = [
            'title' => 'Data User yang Dihapus',
            'deleted_user' => $M_user->getDeletedUser(),
            'showWelcome' => false 
        ];

        return view('user1', $data);
    }

    public function hapus_user($id)
    {
        $M_user = new M_user();
        if ($M_user->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen user ID: $id");

            return redirect()->to('user/dihapus_user')->with('success', 'User berhasil dihapus secara permanen');
        }
        return redirect()->to('user/dihapus_user')->with('error', 'User tidak ditemukan atau gagal dihapus');
    }

    public function delete_user($id)
    {
        $M_user = new M_user();
        if ($M_user->softDelete($id)) {
            $this->logActivity("Menghapus user ID: $id (soft delete)");

            return redirect()->to('user/dihapus_user')->with('success', 'User berhasil dihapus (soft delete)');
        }
        return redirect()->to('user/tabel_user')->with('error', 'User tidak ditemukan atau gagal dihapus');
    }

    public function restore_user($id)
    {
        $M_user = new M_user();

        if ($M_user->restore($id)) {
            $this->logActivity("Mengembalikan user ID: $id (soft delete)");
            return redirect()->to('user/tabel_user')->with('success', 'User berhasil direstore');
        }
        return redirect()->to('user/dihapus_user')->with('error', 'User tidak ditemukan');
    }

    public function input_user()
    {
        $data = [
            'title' => 'Input User'
        ];

        return view('tambah_user', $data);
    }

    public function tambah_user()
    {
        $model = new M_user();

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['foto'] = $newName; 
        }

        $data = [
            'username'   => $this->request->getPost('username'),
            'nama_user'  => $this->request->getPost('nama_user'),
            'email'      => $this->request->getPost('email'),
            'password'   => md5($this->request->getPost('password')),
            'level'      => $this->request->getPost('level'),
            'foto'       => $namaFoto, 
        ];

        if ($model->tambahUser($data)) {
            return redirect()->to(base_url('user/tabel_user'))->with('success', 'User berhasil ditambahkan!');
        } else {
            return redirect()->to(base_url('user/input_user'))->with('error', 'Gagal menambahkan user.');
        }
    }

}