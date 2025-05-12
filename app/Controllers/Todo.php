<?php

namespace App\Controllers;

use App\Models\M_todo;
use App\Models\M_klien;

class Todo extends BaseController
{  
    public function tabel_todo()
    {
        $this->logActivity("Mengakses Tabel Todo");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1, 2, 3])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_todo = new \App\Models\M_todo();
        $status = $this->request->getGet('status');

        if ($status) {
            $todo = $M_todo->where('status', $status)
                        ->where('statusr', 0) 
                        ->orderBy('id_todo', 'DESC') 
                        ->findAll();
        } else {
            $todo = $M_todo->where('statusr', 0) 
                        ->orderBy('id_todo', 'DESC') 
                        ->findAll();
        }

        $data = [
            'title' => 'To Do List',
            'showWelcome' => false, 
            'todo' => $todo, 
            'status' => $status, 
        ];

        return view('todo', $data);
    }

    public function updateStatus($id_todo)
    {
        $M_todo   = new \App\Models\M_todo();
        $M_konten = new \App\Models\M_konten();
        $M_jadwal = new \App\Models\M_jadwal();

        $todo   = $M_todo->find($id_todo);
        $idJadwal = $todo->id_jadwal;

        $kontens = $M_konten
                    ->where('id_jadwal', $idJadwal)
                    ->findAll();

        $allContentDone = true;
        foreach ($kontens as $k) {
            if ($k->status !== 'Selesai') {
                $allContentDone = false;
                break;
            }
        }

        if (! $allContentDone) {
            return redirect()->back()
                ->with('error', 'Konten untuk jadwal ini belum semua selesai!');
        }

        $newStatus = $this->request->getPost('status');

        $M_todo->update($id_todo, ['status' => $newStatus]);
        $M_jadwal->update($idJadwal, ['status' => 'Selesai']);

        $this->logActivity("Update status To-Do ID $id_todo menjadi '$newStatus' dan Jadwal ID $idJadwal menjadi 'Selesai'");

        return redirect()->to('todo/tabel_todo')
                        ->with('success','To-Do & Jadwal berhasil diperbarui!');
    }

    public function detail_todo($id)
    {
        $session = session();
        $user_id = $session->get('id_user'); 
        $user_level = $session->get('level'); 

        $logModel = new \App\Models\M_log();
        $M_todo = new M_todo();

        $logModel->saveLog($todo_id, "id_todo={$todo_id} mencoba mengakses detail todo ID {$id}", $ip_address);

        $todo = $M_todo->getTodoById($id);

        if (!$todo) {
            $logModel->saveLog($todo_id, "id_todo={$todo_id} tidak menemukan data todo ID {$id}", $ip_address);
            return redirect()->to(base_url('todo/tabel_todo'))->with('error', 'Data todo tidak ditemukan.');
        }

        $logModel->saveLog($todo_id, "id_todo={$todo_id} berhasil melihat detail todo ID {$id}", $ip_address);

        $data = [
            'title' => 'Detail Todo',
            'todo' => $todo
        ];

        return view('detail_todo', $data);
    }

    public function input_todo()
    {
        $db     = \Config\Database::connect();
        $builder = $db->table('klien');
    
        $klien = $builder
                    ->orderBy('nama_klien', 'ASC')
                    ->get()               
                    ->getResult();         
    
        return view('tambah_todo', [
            'title' => 'Tambah To Do',
            'klien' => $klien
        ]);
    }
    
    public function tambah_todo()
    {
        $M_todo = new M_todo();

        $data = [
            'tanggal'   => $this->request->getPost('tanggal'),
            'kegiatan'  => $this->request->getPost('kegiatan'),
            'status'    => $this->request->getPost('status'),
            'prioritas' => $this->request->getPost('prioritas'),
            'id_klien'  => $this->request->getPost('id_klien'),
        ];

        if ($M_todo->addTodo($data)) {
            return redirect()->to('todo/tabel_todo')->with('success', 'To-Do berhasil ditambahkan!');
        } else {
            return redirect()->to('todo/tabel_todo')->with('error', 'Gagal menambahkan To-Do!');
        }
    }

    public function dihapus_todo()
    {
        $this->logActivity("Mengakses Tabel Data To do yang Dihapus");

        if (!session()->has('id_user')) { 
            return redirect()->to('login/halaman_login');
        }

        if (!in_array(session()->get('level'), [1])) {
            return redirect()->to('home/dashboard'); 
        }

        $M_todo = new M_todo();
        $data = [
            'title' => 'Data To do yang Dihapus',
            'deleted_todo' => $M_todo->getDeletedTodo(),
            'showWelcome' => false 
        ];

        return view('todo1', $data);
    }

    public function hapus_todo($id)
    {
        $M_todo = new M_todo();
        if ($M_todo->deletePermanen($id)) {
            $this->logActivity("Menghapus permanen todo ID: $id");

            return redirect()->to('todo/dihapus_todo')->with('success', 'To do berhasil dihapus secara permanen');
        }
        return redirect()->to('todo/dihapus_todo')->with('error', 'To do tidak ditemukan atau gagal dihapus');
    }

    public function delete_todo($id)
    {
        $M_todo = new M_todo();
        if ($M_todo->softDelete($id)) {
            $this->logActivity("Menghapus todo ID: $id (soft delete)");

            return redirect()->to('todo/dihapus_todo')->with('success', 'To do berhasil dihapus (soft delete)');
        }
        return redirect()->to('todo/tabel_todo')->with('error', 'To do tidak ditemukan atau gagal dihapus');
    }

    public function restore_todo($id)
    {
        $M_todo = new M_todo();

        if ($M_todo->restore($id)) {
            $this->logActivity("Mengembalikan todo ID: $id (soft delete)");
            return redirect()->to('todo/tabel_todo')->with('success', 'To do berhasil direstore');
        }
        return redirect()->to('todo/dihapus_todo')->with('error', 'To do tidak ditemukan');
    }

}