<?php

namespace App\Controllers;

use App\Models\M_role;
use App\Models\M_menu;
use App\Models\M_akses;

class HakAkses extends BaseController
{
    public function index()
    {
        $this->logActivity("Mengakses Hak Akses");

        $roleModel = new M_role();
        $menuModel = new M_menu();
        $aksesModel = new M_akses();

        $roles = $roleModel->findAll();
        $menus = $menuModel->orderBy('urutan', 'ASC')->findAll();

        $aksesData = [];

        $allAkses = $aksesModel->findAll();
        foreach ($allAkses as $akses) {
            $idRole = $akses['id_role'];
            $idMenu = $akses['id_menu'];

            $aksesData[$idRole][$idMenu] = [
                'can_view' => (bool)$akses['can_view'],
                'can_add' => (bool)$akses['can_add'],
                'can_edit' => (bool)$akses['can_edit'],
                'can_delete' => (bool)$akses['can_delete'],
            ];
        }

        return view('hak_akses', [
            'roles' => $roles,
            'menus' => $menus,
            'aksesData' => $aksesData,
        ]);
    }

    public function update_akses()
    {
        $aksesModel = new M_akses(); 
        $id_role = $this->request->getPost('id_role');
        $menus = $this->request->getPost('menu');

        if (empty($menus)) {
            return redirect()->to('/hakakses')->with('error', 'Tidak ada menu yang dikirimkan.');
        }

        $aksesModel->where('id_role', $id_role)->delete();

        foreach ($menus as $item) {
            $data = [
                'id_role'    => $id_role,
                'id_menu'    => $item['id_menu'],
                'can_view'   => isset($item['can_view']) ? 1 : 0,
                'can_add'    => isset($item['can_add']) ? 1 : 0,
                'can_edit'   => isset($item['can_edit']) ? 1 : 0,
                'can_delete' => isset($item['can_delete']) ? 1 : 0
            ];
            $aksesModel->insert($data);
        }

        return redirect()->to('/hakakses')->with('success', 'Hak akses berhasil diperbarui.');
    }
}
