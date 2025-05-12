<?php

namespace App\Controllers;

use App\Models\M_plartform;

class Plartform extends BaseController
{  
    public function tabel_plartform()
    {
        $this->logActivity("Mengakses Tabel Plartform");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2, 3])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_plartform = new M_plartform(); 
        $data = [
            'title' => 'Data Plartform',
            'showWelcome' => false, 
            'plartform' => $M_plartform->getPlartform(),
        ];

        return view('plartform', $data);
    }

    public function detail_plartform($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_plartform = new M_plartform();

        $logModel->saveLog($plartform_id, "id_plartform={$plartform_id} mencoba mengakses detail plartform ID {$id}", $ip_address);

        $plartform = $M_plartform->getPlartformById($id);

        if (!$plartform) {
            $logModel->saveLog($plartform_id, "id_plartform={$plartform_id} tidak menemukan data plartform ID {$id}", $ip_address);
            return redirect()->to(base_url('home/plartform'))->with('error', 'Data plartform tidak ditemukan.');
        }

        $logModel->saveLog($plartform_id, "id_plartform={$plartform_id} berhasil melihat detail plartform ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail Plartform',
            'plartform' => $plartform
        ];

        return view('detail_plartform', $data);
    }

    public function dihapus_plartform()
    {
        $this->logActivity("Mengakses Tabel Data Plartform yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_plartform = new M_plartform();
        $data = [
            'title' => 'Data Plartform yang Dihapus',
            'deleted_plartform' => $M_plartform->getDeletedPlartform(),
            'showWelcome' => false 
        ];

        return view('plartform1', $data);
    }

    public function hapus_plartform($id)
    {
        $M_plartform = new M_plartform();
        if ($M_plartform->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen plartform ID: $id");

            return redirect()->to('plartform/dihapus_plartform')->with('success', 'Plartform berhasil dihapus secara permanen');
        }
        return redirect()->to('plartform/dihapus_plartform')->with('error', 'Plartform tidak ditemukan atau gagal dihapus');
    }

    public function delete_plartform($id)
    {
        $M_plartform = new M_plartform();
        if ($M_plartform->softDelete($id)) {
            $this->logActivity("Menghapus plartform ID: $id (soft delete)");

            return redirect()->to('plartform/dihapus_plartform')->with('success', 'Plartform berhasil dihapus (soft delete)');
        }
        return redirect()->to('plartform/tabel_plartform')->with('error', 'Plartform tidak ditemukan atau gagal dihapus');
    }

    public function restore_plartform($id)
    {
        $M_plartform = new M_plartform();

        if ($M_plartform->restore($id)) {
            $this->logActivity("Mengembalikan plartform ID: $id (soft delete)");
            return redirect()->to('plartform/tabel_plartform')->with('success', 'Plartform berhasil direstore');
        }
        return redirect()->to('plartform/dihapus_plartform')->with('error', 'Plartform tidak ditemukan');
    }

    public function input_plartform()
    {
        $data = [
            'title' => 'Input Plartform'
        ];

        return view('tambah_plartform', $data);
    }

    public function tambah_plartform()
    {
        $model = new M_plartform();

        $data = [
            'nama_plartform'   => $this->request->getPost('nama_plartform'),
            'tarif'            => $this->request->getPost('tarif'),
        ];

        if ($model->tambahPlartform($data)) {
            $logMessage = "Menambahkan Plartform: {$data['nama_plartform']} ({$data['nama_plartform']}) di {$data['kontak']}";
            $this->logActivity($logMessage);
        
            log_message('info', $logMessage);
            return redirect()->to(base_url('plartform/tabel_plartform'))->with('success', 'Plartform berhasil ditambahkan!');
        } else {
            log_message('error', "Gagal menambahkan plartform: {$data['nama_plartform']} ({$data['kode_plartform']}).");
            return redirect()->to(base_url('plartform/input_plartform'))->with('error', 'Gagal menambahkan plartform.');
        }
    }

    public function edit_plartform($id)
    {
        $model = new M_plartform();
        $plartform = $model->getPlartformById($id);

        if (!$plartform) {
            return redirect()->to(base_url('plartform/tabel_plartform'))->with('error', 'Data plartform tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Plartform',
            'plartform' => $plartform
        ];

        return view('update_plartform', $data);
    }

    public function update_plartform($id_plartform)
    {
        $model = new M_plartform(); 
        $existingData = $model->find($id_plartform);

        if (!$existingData) {
            return redirect()->to(base_url('home/tabel_plartform'))->with('error', 'Data plartform tidak ditemukan.');
        }   

        $newData = [
            'nama_plartform' => $this->request->getPost('nama_plartform'),
            'tarif'     => $this->request->getPost('tarif'),
        ];

        $changes = [];
        foreach ($newData as $key => $value) {
            if ($existingData[$key] != $value) {
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . " dari '" . $existingData[$key] . "' ke '" . $value . "'";
            }
        }

        if (!empty($changes)) {
            if ($model->update($id_plartform, $newData)) { 
                $logMessage = "Mengedit Plartform ID $id_plartform - " . implode(', ', $changes);
                $this->logActivity($logMessage);
                log_message('debug', 'Query update berhasil: ' . json_encode($newData));
            } else {
                log_message('error', 'Query update gagal: ' . json_encode($model->errors()));
            }
        } else {
            log_message('debug', 'Tidak ada perubahan data untuk Plartform ID ' . $id_plartform);
        }

        return redirect()->to(base_url('plartform/tabel_plartform'))->with('success', 'Plartform berhasil diperbarui!');
    }



}