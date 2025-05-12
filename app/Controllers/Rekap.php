<?php

namespace App\Controllers;

use App\Models\M_rekap;

class Rekap extends BaseController
{  
    public function tabel_rekap()
    {
        $this->logActivity("Mengakses Tabel Rekap");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2, 3])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_rekap = new M_rekap(); 
        $data = [
            'title' => 'Data Rekap',
            'showWelcome' => false, 
            'rekap' => $M_rekap->getAll(),
        ];

        return view('rekap', $data);
    }

    public function edit_rekap($id)
    {
        $model = new \App\Models\M_rekap();
        $rekap = $model->find($id);

        if (!$rekap) {
            return redirect()->to(base_url('rekap/tabel_rekap'))
                            ->with('error', 'Data rekap tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Rekap Keuangan',
            'rekap' => $rekap,
        ];

        return view('update_rekap', $data);
    }

    public function update_rekap()
    {
        $model = new \App\Models\M_rekap();
        $id_rekap = $this->request->getPost('id_rekap'); 

        $existing = $model->find($id_rekap);

        if (!$existing) {
            return redirect()->to(base_url('rekap/tabel_rekap'))
                            ->with('error', 'Data rekap tidak ditemukan.');
        }

        $jumlah = $this->request->getPost('jumlah');
        $jumlah = preg_replace('/[^\d]/', '', $jumlah); 

        $newData = [
            'tanggal'   => $this->request->getPost('tanggal'),
            'jenis'     => $this->request->getPost('jenis'),
            'kategori'  => $this->request->getPost('kategori'),
            'jumlah'    => $jumlah,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $model->update($id_rekap, $newData);

        return redirect()->to(base_url('rekap/tabel_rekap'))
                        ->with('success', 'Rekap keuangan berhasil diperbarui!');
    }

    public function input_rekap()
    {
        $data = [
            'title' => 'Input Rekap'
        ];

        return view('tambah_rekap', $data);
    }

    public function tambah_rekap()
    {
        $rekapModel = model('App\Models\M_rekap'); 
    
        $tanggal  = $this->request->getPost('tanggal');
        $jenis    = $this->request->getPost('jenis');
        $kategori = $this->request->getPost('kategori');
        
        $jumlah_raw = $this->request->getPost('jumlah');
        $jumlah = preg_replace('/[^0-9]/', '', $jumlah_raw); 
    
        $deskripsi = $this->request->getPost('deskripsi');
    
        $data = [
            'tanggal'   => $tanggal,
            'jenis'     => $jenis,
            'kategori'  => $kategori,
            'jumlah'    => $jumlah,
            'deskripsi' => $deskripsi,
        ];
    
        $rekapModel->insert($data); 
    
        if ($rekapModel->insertID()) {
            $this->logActivity("Menambahkan rekap: $jenis - $kategori sebesar Rp" . number_format($jumlah, 0, ',', '.'));
    
            return redirect()->to(base_url('rekap/tabel_rekap'))->with('success', 'Rekap berhasil ditambahkan!');
        } else {
            return redirect()->to(base_url('rekap/input_rekap'))->with('error', 'Gagal menambahkan rekap.');
        }
    }
    
    public function detail_rekap($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_rekap = new M_rekap();

        $logModel->saveLog($rekap_id, "id_rekap={$rekap_id} mencoba mengakses detail rekap ID {$id}", $ip_address);

        $rekap = $M_rekap->getById($id);

        if (!$rekap) {
            $logModel->saveLog($rekap_id, "id_rekap={$rekap_id} tidak menemukan data rekap ID {$id}", $ip_address);
            return redirect()->to(base_url('rekap/tabel_rekap'))->with('error', 'Data rekap tidak ditemukan.');
        }

        $logModel->saveLog($rekap_id, "id_rekap={$rekap_id} berhasil melihat detail rekap ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail Rekap',
            'rekap' => $rekap
        ];

        return view('detail_rekap', $data);
    }

    public function dihapus_rekap()
    {
        $this->logActivity("Mengakses Tabel Data Rekap yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_rekap = new M_rekap();
        $data = [
            'title' => 'Data Rekap yang Dihapus',
            'deleted_rekap' => $M_rekap->getDeletedRekap(),
            'showWelcome' => false 
        ];

        return view('rekap1', $data);
    }

    public function hapus_rekap($id)
    {
        $M_rekap = new M_rekap();
        if ($M_rekap->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen rekap ID: $id");

            return redirect()->to('rekap/dihapus_rekap')->with('success', 'Rekap berhasil dihapus secara permanen');
        }
        return redirect()->to('rekap/dihapus_rekap')->with('error', 'Rekap tidak ditemukan atau gagal dihapus');
    }

    public function delete_rekap($id)
    {
        $M_rekap = new M_rekap();
        if ($M_rekap->softDelete($id)) {
            $this->logActivity("Menghapus rekap ID: $id (soft delete)");

            return redirect()->to('rekap/dihapus_rekap')->with('success', 'Rekap berhasil dihapus (soft delete)');
        }
        return redirect()->to('rekap/tabel_rekap')->with('error', 'Rekap tidak ditemukan atau gagal dihapus');
    }

    public function restore_rekap($id)
    {
        $M_rekap = new M_rekap();

        if ($M_rekap->restore($id)) {
            $this->logActivity("Mengembalikan rekap ID: $id (soft delete)");
            return redirect()->to('rekap/tabel_rekap')->with('success', 'Rekap berhasil direstore');
        }
        return redirect()->to('rekap/dihapus_rekap')->with('error', 'Rekap tidak ditemukan');
    }

}