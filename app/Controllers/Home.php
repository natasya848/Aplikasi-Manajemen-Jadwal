<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_todo;
use App\Models\M_jadwal;
use App\Models\M_konten;
use App\Models\M_rekap;
use App\Models\M_role;
use App\Models\M_menu;
use App\Models\M_akses;
use App\Models\M_setting;

class Home extends BaseController
{  
    public function dashboard()
    {
        $M_user = new M_user();
        $M_jadwal = new M_jadwal();       
        $M_konten = new M_konten();        
        $M_todo = new M_todo();           
        $M_rekap = new M_rekap();        

        $id_user = session()->get('id_user');
        $level = session()->get('level');

        $data = [
            'title' => 'Dashboard', 
            'showWelcome' => true,
            'aktivitasTerakhir' => $M_user->getRecentActivities($id_user),
            'totalUser'        => $M_user->countAll(),
            'totalKonten'      => $M_konten->countAll(),
            'totalTodo'        => $M_todo->countAll(),
            'totalPemasukan'   => $M_rekap->getTotal('Pemasukkan'),
            'totalPengeluaran' => $M_rekap->getTotal('Pengeluaran'),
        ];

        if (in_array($level, [3])) {
            $data['jadwalHariIni'] = $M_jadwal->getTodaySchedule();
            $data['pengingatTerdekat'] = $M_jadwal->getUpcomingReminder();
            $data['kontenAktif'] = $M_konten->getActiveContents(); 
            $data['todoPrioritas'] = $M_todo->getHighPriorityTasks(); 
            $data['rekapKeuangan'] = [
                'pemasukkan' => $M_rekap->getTotal('Pemasukkan'),
                'pengeluaran' => $M_rekap->getTotal('Pengeluaran'),
            ];
        }

        return view($level == 1 || $level == 2 ? 'dashadmin' : 'dashboard', $data);
    }

    public function profile()
    { 
        $this->logActivity("Mengakses Profil");

        if (!session()->has('id_user')) {
            return redirect()->to('login/halaman_login')->with('error', 'Silakan login terlebih dahulu!');
        }

        $userModel = new M_user();
        $user = $userModel->find(session()->get('id_user'));

        if (!$user) {
            return redirect()->to('login/halaman_login')->with('error', 'User tidak ditemukan!');
        }

        return view('profile', ['user' => $user]); 
    }

    public function updateProfile()
    {
        $session = session();
        $id_user = $session->get('id_user');
        $userModel = new M_User();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),  
            'alamat' => $this->request->getPost('alamat'), 
        ];
        
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['foto'] = $newName; 
        }

        $userModel->update($id_user, $data);

         $this->logActivity("Mengubah profil pengguna dengan ID $id_user.");
        
        return redirect()->to('home/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function logout()
    {   
        $this->logActivity("Logout dari sistem");
        
        session()->destroy();
        return redirect()->to('login/halaman_login');
    }

//     public function hak_akses()
// {
//     $roleModel = new \App\Models\M_role();
//     $menuModel = new \App\Models\M_menu();
//     $aksesModel = new \App\Models\M_akses();

//     $roles = $roleModel->findAll();
//     $menus = $menuModel->orderBy('urutan', 'ASC')->findAll();

//     $aksesData = [];

//     $allAkses = $aksesModel->findAll();
//     foreach ($allAkses as $akses) {
//         $idRole = $akses['id_role'];
//         $idMenu = $akses['id_menu'];

//         $aksesData[$idRole][$idMenu] = [
//             'can_view' => (bool)$akses['can_view'],
//             'can_add' => (bool)$akses['can_add'],
//             'can_edit' => (bool)$akses['can_edit'],
//             'can_delete' => (bool)$akses['can_delete'],
//         ];
//     }

//     return view('hak_akses', [
//         'roles' => $roles,
//         'menus' => $menus,
//         'aksesData' => $aksesData,
//     ]);
// }

// public function update_akses()
// {
//     $aksesModel = new \App\Models\M_akses(); 
//     $id_role = $this->request->getPost('id_role');
//     $menus = $this->request->getPost('menu');

//     if (empty($menus)) {
//         return redirect()->to('/home/hak_akses')->with('error', 'Tidak ada menu yang dikirimkan.');
//     }

//     // Hapus hak akses lama
//     $aksesModel->where('id_role', $id_role)->delete();

//     $savedMenus = [];
//     foreach ($this->request->getPost('menu') as $item) {
//         $data = [
//             'id_role'    => $this->request->getPost('id_role'),
//             'id_menu'    => $item['id_menu'],
//             'can_view'   => isset($item['can_view']) ? 1 : 0,
//             'can_add'    => isset($item['can_add']) ? 1 : 0,
//             'can_edit'   => isset($item['can_edit']) ? 1 : 0,
//             'can_delete' => isset($item['can_delete']) ? 1 : 0
//         ];
//         $aksesModel->insert($data);
//     }
    

//     return redirect()->to('/home/hak_akses')->with('success', 'Hak akses berhasil diperbarui.');
// }

    public function setting() 
    {
        $this->logActivity("Mengakses Settings");
        
        $M_setting = new \App\Models\M_setting();
        $data['setting'] = $M_setting->tampil1();

        if (!$data['setting']) {
            $data['setting'] = [
                'nama'  => 'Website Default',
                'foto'  => 'default_logo.png',
            ];
        }

        return view('setting', $data);
    }

    public function update_setting()
    {
        $settingModel = new \App\Models\M_setting();
        $setting = $settingModel->first();

        $nama = $this->request->getPost('nama');
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads', $namaFoto);

            if (!empty($setting['foto']) && $setting['foto'] !== 'default-logo.png') {
                @unlink('uploads/' . $setting['foto']);
            }
        } else {
            $namaFoto = $setting['foto']; 
        }

        $settingModel->update($setting['id'], [
            'nama' => $nama,
            'foto' => $namaFoto
        ]);

        return $this->response->setJSON(['success' => true]);
    }

}