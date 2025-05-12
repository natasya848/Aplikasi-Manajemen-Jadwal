<?php

namespace App\Controllers;

use App\Models\M_konten;
use App\Models\M_rekap;
use App\Models\M_histori;
use App\Models\M_jadwal;

class Konten extends BaseController
{  
    public function tabel_konten()
    {
        $this->logActivity("Mengakses Tabel Konten");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2, 3])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_konten = new M_konten(); 
        $data = [
            'title' => 'Data Konten',
            'showWelcome' => false, 
            'konten' => $M_konten->getKontenWithPlartform(),
        ];

        return view('konten', $data);
    }

    public function detail_konten($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_konten = new M_konten();

        $logModel->saveLog($konten_id, "id_konten={$konten_id} mencoba mengakses detail konten ID {$id}", $ip_address);

        $konten = $M_konten->getKontenById($id);

        if (!$konten) {
            $logModel->saveLog($konten_id, "id_konten={$konten_id} tidak menemukan data konten ID {$id}", $ip_address);
            return redirect()->to(base_url('konten/tabel_konten'))->with('error', 'Data konten tidak ditemukan.');
        }

        $logModel->saveLog($konten_id, "id_konten={$konten_id} berhasil melihat detail konten ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail Konten',
            'konten' => $konten
        ];

        return view('detail_konten', $data);
    }

    public function input_konten()
    {
        $M_konten = model('App\Models\M_konten');
        
        $data = [
            'title' => 'Input Konten',
            'jadwal' => $M_konten->getJadwalWithProdukKonten(),
            'platform' => $M_konten->getPlatform()
        ];

        return view('tambah_konten', $data);
    }

    public function tambah_konten()
    {
        $platforms = $this->request->getPost('platform');

        $file = $this->request->getFile('url_file');
        $fileName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/konten/', $fileName);
        }

        $dataKonten = [
            'judul'      => $this->request->getPost('judul'),
            'status'     => $this->request->getPost('status'),
            'deadline'   => $this->request->getPost('deadline'),
            'id_jadwal'  => $this->request->getPost('id_jadwal'),
            'url_file'   => $fileName
        ];

        $kontenModel = model('App\Models\M_konten');
        $kontenModel->insert($dataKonten);
        $id_konten = $kontenModel->insertID();

        $db = \Config\Database::connect();
        foreach ($platforms as $id_platform) {
            $db->table('konten_plartform')->insert([
                'id_konten' => $id_konten,
                'id_plartform' => $id_platform
            ]);
        }

        if ($id_konten) {
            $logMessage = "Menambahkan Konten: {$data['nama_konten']} ({$data['nama_konten']}) di {$data['konten']}";
            $this->logActivity($logMessage);
        
            log_message('info', $logMessage);
            return redirect()->to(base_url('konten/tabel_konten'))->with('success', 'Konten berhasil ditambahkan!');
        } else {
            log_message('error', "Gagal menambahkan konten: {$data['nama_konten']} ({$data['kode_konten']}).");
            return redirect()->to(base_url('konten/input_konten'))->with('error', 'Gagal menambahkan konten.');
        }
    }

    public function edit_konten($id)
    {
        $model = new M_konten();
        $konten = $model->getKontenById($id);

        if (!$konten) {
            return redirect()->to(base_url('konten/tabel_konten'))->with('error', 'Data konten tidak ditemukan.');
        }

        $konten_platform = $model->getPlatformByKontenId($id); 
        $konten_platform = array_map(function($p) {
            return $p->id_plartform;
        }, $konten_platform);

        $data = [
            'title'   => 'Edit Konten',
            'konten' => $konten,
            'jadwal' => $model->getJadwalWithProdukKonten(),
            'platform' => $model->getPlatform(),
            'konten_platform' => $konten_platform,
        ];

        return view('update_konten', $data);
    }

    public function update_konten($id_konten)
    {
        $model = new \App\Models\M_konten();
        $existing = $model->find($id_konten);

        if (!$existing) {
            return redirect()->to(base_url('konten/tabel_konten'))
                            ->with('error', 'Data konten tidak ditemukan.');
        }

        $newData = [
        'judul'     => $this->request->getPost('judul'),
        'deadline'  => $this->request->getPost('deadline'),
        'status'    => $this->request->getPost('status'),
        'id_jadwal' => $this->request->getPost('id_jadwal'),
        ];

        $file = $this->request->getFile('url_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!empty($existing->url_file) && is_file(WRITEPATH . '../public/uploads/konten/' . $existing->url_file)) {
                unlink(WRITEPATH . '../public/uploads/konten/' . $existing->url_file);
            }
            $newName = $file->getRandomName();
            $file->move('uploads/konten/', $newName);
            $newData['url_file'] = $newName;
        }

        $changes = [];
        foreach (['judul','deadline','status','id_jadwal','url_file'] as $field) {
            $old = $existing->{$field} ?? '';
            $new = $newData[$field] ?? $old;
            if ($old != $new) {
                $changes[] = ucfirst($field)." dari '$old' ke '$new'";
            }
        }

        $model->update($id_konten, $newData);

        $postedPlats = $this->request->getPost('platform') ?? [];
        
        $existingPlats = $model->getPlatformByKontenId($id_konten);
        $existingIds = array_map(fn($p)=>$p->id_plartform, $existingPlats);

        $toAdd    = array_diff($postedPlats, $existingIds);
        $toRemove = array_diff($existingIds, $postedPlats);

        if ($toRemove) {
            $model->removePlatformFromKonten($id_konten, $toRemove);
            $changes[] = "Hapus platform ID: ".implode(',',$toRemove);
        }
        if ($toAdd) {
            $model->addPlatformToKonten($id_konten, $toAdd);
            $changes[] = "Tambah platform ID: ".implode(',',$toAdd);
        }

        if ($changes) {
            $this->logActivity("Update Konten ID $id_konten: ".implode('; ', $changes));
        }

        return redirect()->to(base_url('konten/tabel_konten'))
                        ->with('success','Konten berhasil diperbarui!');
    }

    public function updateStatusKonten($id)
    {
        $M_konten = new \App\Models\M_konten();
        $M_rekap = new \App\Models\M_rekap();
        $M_histori = new \App\Models\M_histori();
        $M_jadwal = new \App\Models\M_jadwal();
        $M_todo = new \App\Models\M_todo();
    
        $konten = $M_konten->getKontenById($id);
    
        if ($konten) {
            if ($konten->status !== 'Selesai') {
                $M_konten->update($id, ['status' => 'Selesai']);
    
                $M_jadwal->update($konten->id_jadwal, ['status' => 'Selesai']);
    
                $jadwal = $M_jadwal->find($konten->id_jadwal);
    
                if ($jadwal) {
                    $historiData = [
                        'id_klien'      => $jadwal['id_klien'],
                        'id_jadwal'     => $jadwal['id_jadwal'],
                        'tanggal_kerja' => $jadwal['tanggal'],
                        'deskripsi'     => $jadwal['catatan'],
                        'created_at'    => date('Y-m-d H:i:s')
                    ];
    
                    if ($M_histori->insert($historiData)) {
                        log_message('info', 'Histori kerja berhasil dicatat untuk jadwal ID: ' . $jadwal['id_jadwal']);
                    } else {
                        log_message('warning', 'Gagal mencatat histori kerja untuk jadwal ID: ' . $jadwal['id_jadwal']);
                    }
                }
    
                $platforms = $M_konten->getPlatformByKonten($konten->id_konten);
                $total = 0;
                $nama_platforms = [];
                foreach ($platforms as $p) {
                    $total += $p->tarif;
                    $nama_platforms[] = $p->nama_plartform;
                }
    
                $M_rekap->insertRekap([
                    'tanggal' => date('Y-m-d'),
                    'jenis' => 'Pemasukkan',
                    'kategori' => 'Endorse',
                    'jumlah' => $total,
                    'deskripsi' => 'Konten untuk platform: ' . implode(', ', $nama_platforms)
                ]);
    
                $todos = $M_todo->where('id_jadwal', $konten->id_jadwal)->findAll();
                foreach ($todos as $todo) {
                    $M_todo->update($todo->id_todo, [
                      'status'     => 'Selesai',
                      'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                  }                  

    
                return redirect()->to('konten/tabel_konten')->with('success', 'Status konten berhasil diperbarui, jadwal selesai, histori tercatat, dan pemasukkan masuk.');
            } else {
                return redirect()->to('konten/tabel_konten')->with('warning', 'Konten sudah ditandai sebagai selesai.');
            }
        }
    
        return redirect()->to('konten/tabel_konten')->with('error', 'Konten tidak ditemukan.');
    }
    
    public function dihapus_konten()
    {
        $this->logActivity("Mengakses Tabel Data Konten yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_konten = new M_konten();
        $data = [
            'title' => 'Data Konten yang Dihapus',
            'deleted_konten' => $M_konten->getDeletedKonten(),
            'showWelcome' => false 
        ];

        return view('konten1', $data);
    }

    public function hapus_konten($id)
    {
        $M_konten = new M_konten();
        if ($M_konten->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen konten ID: $id");

            return redirect()->to('konten/dihapus_konten')->with('success', 'Konten berhasil dihapus secara permanen');
        }
        return redirect()->to('konten/dihapus_konten')->with('error', 'Konten tidak ditemukan atau gagal dihapus');
    }

    public function delete_konten($id)
    {
        $M_konten = new M_konten();
        if ($M_konten->softDelete($id)) {
            $this->logActivity("Menghapus konten ID: $id (soft delete)");

            return redirect()->to('konten/dihapus_konten')->with('success', 'Konten berhasil dihapus (soft delete)');
        }
        return redirect()->to('konten/tabel_konten')->with('error', 'Konten tidak ditemukan atau gagal dihapus');
    }

    public function restore_konten($id)
    {
        $M_konten = new M_konten();

        if ($M_konten->restore($id)) {
            $this->logActivity("Mengembalikan konten ID: $id (soft delete)");
            return redirect()->to('konten/tabel_konten')->with('success', 'Konten berhasil direstore');
        }
        return redirect()->to('konten/dihapus_konten')->with('error', 'Konten tidak ditemukan');
    }

}