<?php

namespace App\Controllers;

use App\Models\M_jadwal;
use App\Models\M_klien;
use App\Models\M_todo;

class Jadwal extends BaseController
{  
    public function tabel_jadwal()
    {
        $this->logActivity("Mengakses Tabel Jadwal");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2, 3])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_jadwal = new M_jadwal(); 
        $data = [
            'title' => 'Data Jadwal',
            'showWelcome' => false, 
            'jadwal' => $M_jadwal->getJadwal(),
        ];

        return view('jadwal', $data);
    }

    public function detail_jadwal($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_jadwal = new M_jadwal();

        $logModel->saveLog($jadwal_id, "id_jadwal={$jadwal_id} mencoba mengakses detail jadwal ID {$id}", $ip_address);

        $jadwal = $M_jadwal->getJadwalById($id);

        if (!$jadwal) {
            // $logModel->saveLog($jadwal_id, "id_jadwal={$jadwal_id} tidak menemukan data jadwal ID {$id}", $ip_address);
            return redirect()->to(base_url('jadwal/tabel_jadwal'))->with('error', 'Data jadwal tidak ditemukan.');
        }

        $logModel->saveLog($jadwal_id, "id_jadwal={$jadwal_id} berhasil melihat detail jadwal ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail Jadwal',
            'jadwal' => $M_jadwal->getJadwalById($id),
        ];

        return view('detail_jadwal', $data);
    }

    public function input_jadwal()
    {
        $M_klien = model('App\Models\M_klien'); 
        $klien = $M_klien->tampil();
        
        $data = [
            'title' => 'Input Jadwal',
            'klien' => $klien, 
        ];

        return view('tambah_jadwal', $data);
    }

    public function tambah_jadwal()
    {
        $M_jadwal = new M_jadwal();
        $M_todo   = new M_todo();
        $M_klien  = new M_klien(); 

        $dataJadwal = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'id_klien'    => $this->request->getPost('id_klien'),
            'tanggal'     => $this->request->getPost('tanggal'),
            'jam'         => $this->request->getPost('jam'),
            'status'      => $this->request->getPost('status'),
            'catatan'     => $this->request->getPost('catatan'),
            'pengingat'   => $this->request->getPost('pengingat'),
        ];

        $klien = $M_klien->find($dataJadwal['id_klien']);
        $nama_klien = $klien ? $klien['nama_klien'] : 'Klien Tidak Ditemukan';  

        if ($M_jadwal->insert($dataJadwal)) {
            $idJadwal = $M_jadwal->getInsertID();

            $M_todo->insert([
                'tanggal'   => $dataJadwal['tanggal'],
                'kegiatan'  => "Jadwal: {$dataJadwal['nama_produk']} untuk klien {$nama_klien}",
                'status'    => 'Belum Mulai',
                'prioritas' => 'Sedang',
                'id_klien'  => $dataJadwal['id_klien'],
                'id_jadwal'  => $idJadwal,  
                'created_at'=> date('Y-m-d H:i:s'),
            ]);

            return redirect()->to(base_url('jadwal/tabel_jadwal'))
                            ->with('success', 'Jadwal dan To-Do berhasil dibuat!');
        } else {
            return redirect()->to(base_url('jadwal/input_jadwal'))
                            ->with('error', 'Gagal menambahkan jadwal.');
        }
    }

    public function edit_jadwal($id)
    {
        $model = new M_jadwal();
        $M_klien = model('App\Models\M_klien'); 
        $jadwal = $model->getJadwalById($id);
        $klien = $M_klien->tampil();


        if (!$jadwal) {
            return redirect()->to(base_url('jadwal/tabel_jadwal'))->with('error', 'Data jadwal tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Jadwal',
            'jadwal' => $jadwal,
            'klien' => $klien
        ];

        return view('update_jadwal', $data);
    }

    public function update_jadwal($id_jadwal)
    {
        $model = new M_jadwal(); 
        $existingData = $model->find($id_jadwal);

        if (!$existingData) {
            return redirect()->to(base_url('jadwal/tabel_jadwal'))->with('error', 'Data jadwal tidak ditemukan.');
        }   

        $newData = [
            'nama_produk'  => $this->request->getPost('nama_produk'),
            'id_klien'     => $this->request->getPost('id_klien'),
            'tanggal'      => $this->request->getPost('tanggal'),
            'jam'          => $this->request->getPost('jam'),
            'status'       => $this->request->getPost('status'),
            'catatan'      => $this->request->getPost('catatan'),
            'pengingat'    => $this->request->getPost('pengingat'),
        ];

        $changes = [];
        foreach ($newData as $key => $value) {
            if ($existingData[$key] != $value) {
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . " dari '" . $existingData[$key] . "' ke '" . $value . "'";
            }
        }

        if (!empty($changes)) {
            if ($model->update($id_jadwal, $newData)) { 
                $logMessage = "Mengedit Jadwal ID $id_jadwal - " . implode(', ', $changes);
                $this->logActivity($logMessage);
                log_message('debug', 'Query update berhasil: ' . json_encode($newData));
            } else {
                log_message('error', 'Query update gagal: ' . json_encode($model->errors()));
            }
        } else {
            log_message('debug', 'Tidak ada perubahan data untuk Jadwal ID ' . $id_jadwal);
        }

        return redirect()->to(base_url('jadwal/tabel_jadwal'))->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function dihapus_jadwal()
    {
        $this->logActivity("Mengakses Tabel Data Jadwal yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_jadwal = new M_jadwal();
        $data = [
            'title' => 'Data Jadwal yang Dihapus',
            'deleted_jadwal' => $M_jadwal->getDeletedJadwal(),
            'showWelcome' => false 
        ];

        return view('jadwal1', $data);
    }

    public function hapus_jadwal($id)
    {
        $M_jadwal = new M_jadwal();
        if ($M_jadwal->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen jadwal ID: $id");

            return redirect()->to('jadwal/dihapus_jadwal')->with('success', 'Jadwal berhasil dihapus secara permanen');
        }
        return redirect()->to('jadwal/dihapus_jadwal')->with('error', 'Jadwal tidak ditemukan atau gagal dihapus');
    }

    public function delete_jadwal($id)
    {
        $M_jadwal = new M_jadwal();
        if ($M_jadwal->softDelete($id)) {
            $this->logActivity("Menghapus jadwal ID: $id (soft delete)");

            return redirect()->to('jadwal/dihapus_jadwal')->with('success', 'Jadwal berhasil dihapus (soft delete)');
        }
        return redirect()->to('jadwal/tabel_jadwal')->with('error', 'Jadwal tidak ditemukan atau gagal dihapus');
    }

    public function restore_jadwal($id)
    {
        $M_jadwal = new M_jadwal();

        if ($M_jadwal->restore($id)) {
            $this->logActivity("Mengembalikan jadwal ID: $id (soft delete)");
            return redirect()->to('jadwal/tabel_jadwal')->with('success', 'Jadwal berhasil direstore');
        }
        return redirect()->to('jadwal/dihapus_jadwal')->with('error', 'Jadwal tidak ditemukan');
    }

}