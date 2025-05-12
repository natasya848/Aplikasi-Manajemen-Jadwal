<?php

namespace App\Controllers;

use App\Models\M_histori;
use App\Models\M_log;

class Histori extends BaseController
{  
    public function tabel_histori()
    {
        $this->logActivity("Mengakses Tabel Histori");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2, 3])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_histori = new M_histori(); 
        $data = [
            'title' => 'Data Histori',
            'showWelcome' => false, 
            'histori' => $M_histori->getHistoriJoin(),
        ];

        return view('histori', $data);
    }

    public function detail_histori($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_histori = new M_histori();

        $logModel->saveLog($histori_id, "id_histori={$histori_id} mencoba mengakses detail histori ID {$id}", $ip_address);

        $histori = $M_histori->getHistoriById($id);

        if (!$histori) {
            $logModel->saveLog($histori_id, "id_histori={$histori_id} tidak menemukan data histori ID {$id}", $ip_address);
            return redirect()->to(base_url('home/histori'))->with('error', 'Data histori tidak ditemukan.');
        }

        $logModel->saveLog($histori_id, "id_histori={$histori_id} berhasil melihat detail histori ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail Histori',
            'histori' => $histori
        ];

        return view('detail_histori', $data);
    }

    public function edit_histori($id)
    {
        $model = new M_histori();
        $histori = $model->getHistoriById($id);

        if (!$histori) {
            return redirect()->to(base_url('histori/tabel_histori'))->with('error', 'Data histori tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Histori',
            'histori' => $histori
        ];

        return view('update_histori', $data);
    }

    public function update_histori($id_histori)
    {
        $model = new M_histori(); 
        $existingData = $model->find($id_histori);

        if (!$existingData) {
            return redirect()->to(base_url('histori/tabel_histori'))->with('error', 'Data histori tidak ditemukan.');
        }   

        $newData = [
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ];

        $changes = [];
        foreach ($newData as $key => $value) {
            if ($existingData[$key] != $value) {
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . " dari '" . $existingData[$key] . "' ke '" . $value . "'";
            }
        }

        if (!empty($changes)) {
            if ($model->update($id_histori, $newData)) { 
                $logMessage = "Mengedit Histori ID $id_histori - " . implode(', ', $changes);
                $this->logActivity($logMessage);
                log_message('debug', 'Query update berhasil: ' . json_encode($newData));
            } else {
                log_message('error', 'Query update gagal: ' . json_encode($model->errors()));
            }
        } else {
            log_message('debug', 'Tidak ada perubahan data untuk Histori ID ' . $id_histori);
        }

        return redirect()->to(base_url('histori/tabel_histori'))->with('success', 'Histori berhasil diperbarui!');
    }

    public function dihapus_histori()
    {
        $this->logActivity("Mengakses Tabel Data Histori yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_histori = new M_histori();
        $data = [
            'title' => 'Data Histori yang Dihapus',
            'deleted_histori' => $M_histori->getDeletedHistori(),
            'showWelcome' => false 
        ];

        return view('histori1', $data);
    }

    public function hapus_histori($id)
    {
        $M_histori = new M_histori();
        if ($M_histori->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen histori ID: $id");

            return redirect()->to('histori/dihapus_histori')->with('success', 'Histori berhasil dihapus secara permanen');
        }
        return redirect()->to('histori/dihapus_histori')->with('error', 'Histori tidak ditemukan atau gagal dihapus');
    }

    public function delete_histori($id)
    {
        $M_histori = new M_histori();
        if ($M_histori->softDelete($id)) {

            $this->logActivity("Menghapus histori ID: $id (soft delete)");

            return redirect()->to('histori/dihapus_histori')->with('success', 'Histori berhasil dihapus (soft delete)');
        }
        return redirect()->to('histori/tabel_histori')->with('error', 'Histori tidak ditemukan atau gagal dihapus');
    }

    public function restore_histori($id)
    {
        $M_histori = new M_histori();

        if ($M_histori->restore($id)) {
            $this->logActivity("Mengembalikan histori ID: $id (soft delete)");
            return redirect()->to('histori/tabel_histori')->with('success', 'Histori berhasil direstore');
        }
        return redirect()->to('histori/dihapus_histori')->with('error', 'Histori tidak ditemukan');
    }
}