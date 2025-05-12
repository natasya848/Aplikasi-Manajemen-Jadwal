<?php

namespace App\Controllers;

use App\Models\M_klien;

class Klien extends BaseController
{  
    public function tabel_klien()
    {
        $this->logActivity("Mengakses Tabel Klien");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2, 3])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_klien = new M_klien(); 
        $data = [
            'title' => 'Data Klien',
            'showWelcome' => false, 
            'klien' => $M_klien->getKlien(),
        ];

        return view('klien', $data);
    }

    public function detail_klien($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_klien = new M_klien();

        $logModel->saveLog($klien_id, "id_klien={$klien_id} mencoba mengakses detail klien ID {$id}", $ip_address);

        $klien = $M_klien->getKlienById($id);

        if (!$klien) {
            $logModel->saveLog($klien_id, "id_klien={$klien_id} tidak menemukan data klien ID {$id}", $ip_address);
            return redirect()->to(base_url('home/klien'))->with('error', 'Data klien tidak ditemukan.');
        }

        $logModel->saveLog($klien_id, "id_klien={$klien_id} berhasil melihat detail klien ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail Klien',
            'klien' => $klien
        ];

        return view('detail_klien', $data);
    }

    public function dihapus_klien()
    {
        $this->logActivity("Mengakses Tabel Data Klien yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_klien = new M_klien();
        $data = [
            'title' => 'Data Klien yang Dihapus',
            'deleted_klien' => $M_klien->getDeletedKlien(),
            'showWelcome' => false 
        ];

        return view('klien1', $data);
    }

    public function hapus_klien($id)
    {
        $M_klien = new M_klien();
        if ($M_klien->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen klien ID: $id");

            return redirect()->to('klien/dihapus_klien')->with('success', 'Klien berhasil dihapus secara permanen');
        }
        return redirect()->to('klien/dihapus_klien')->with('error', 'Klien tidak ditemukan atau gagal dihapus');
    }

    public function delete_klien($id)
    {
        $M_klien = new M_klien();
        if ($M_klien->softDelete($id)) {
            $this->logActivity("Menghapus klien ID: $id (soft delete)");

            return redirect()->to('klien/dihapus_klien')->with('success', 'Klien berhasil dihapus (soft delete)');
        }
        return redirect()->to('klien/tabel_klien')->with('error', 'Klien tidak ditemukan atau gagal dihapus');
    }

    public function restore_klien($id)
    {
        $M_klien = new M_klien();

        if ($M_klien->restore($id)) {
            $this->logActivity("Mengembalikan klien ID: $id (soft delete)");
            return redirect()->to('klien/tabel_klien')->with('success', 'Klien berhasil direstore');
        }
        return redirect()->to('klien/dihapus_klien')->with('error', 'Klien tidak ditemukan');
    }

    public function input_klien()
    {
        $data = [
            'title' => 'Input Klien'
        ];

        return view('tambah_klien', $data);
    }

    public function tambah_klien()
    {
        $model = new M_klien();

        $data = [
            'nama_klien'   => $this->request->getPost('nama_klien'),
            'kontak'       => $this->request->getPost('kontak'),
            'catatan'      => $this->request->getPost('catatan'),
        ];

        if ($model->tambahKlien($data)) {
            $logMessage = "Menambahkan Klien: {$data['nama_klien']} ({$data['nama_klien']}) di {$data['kontak']}";
            $this->logActivity($logMessage);
        
            log_message('info', $logMessage);
            return redirect()->to(base_url('klien/tabel_klien'))->with('success', 'Klien berhasil ditambahkan!');
        } else {
            log_message('error', "Gagal menambahkan klien: {$data['nama_klien']} ({$data['kode_klien']}).");
            return redirect()->to(base_url('klien/input_klien'))->with('error', 'Gagal menambahkan klien.');
        }
    }

    public function edit_klien($id)
    {
        $model = new M_klien();
        $klien = $model->getKlienById($id);

        if (!$klien) {
            return redirect()->to(base_url('klien/tabel_klien'))->with('error', 'Data klien tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Klien',
            'klien' => $klien
        ];

        return view('update_klien', $data);
    }

    public function update_klien($id_klien)
    {
        $model = new M_klien(); 
        $existingData = $model->find($id_klien);

        if (!$existingData) {
            return redirect()->to(base_url('home/tabel_klien'))->with('error', 'Data klien tidak ditemukan.');
        }   

        $newData = [
            'nama_klien' => $this->request->getPost('nama_klien'),
            'kontak'     => $this->request->getPost('kontak'),
            'catatan'    => $this->request->getPost('catatan'),
        ];

        $changes = [];
        foreach ($newData as $key => $value) {
            if ($existingData[$key] != $value) {
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . " dari '" . $existingData[$key] . "' ke '" . $value . "'";
            }
        }

        if (!empty($changes)) {
            if ($model->update($id_klien, $newData)) { 
                $logMessage = "Mengedit Klien ID $id_klien - " . implode(', ', $changes);
                $this->logActivity($logMessage);
                log_message('debug', 'Query update berhasil: ' . json_encode($newData));
            } else {
                log_message('error', 'Query update gagal: ' . json_encode($model->errors()));
            }
        } else {
            log_message('debug', 'Tidak ada perubahan data untuk Klien ID ' . $id_klien);
        }

        return redirect()->to(base_url('klien/tabel_klien'))->with('success', 'Klien berhasil diperbarui!');
    }



}