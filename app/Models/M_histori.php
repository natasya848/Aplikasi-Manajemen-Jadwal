<?php

namespace App\Models;
use CodeIgniter\Model;

class M_histori extends Model {
    protected $table = 'histori';
    protected $primaryKey = 'id_histori';
    protected $allowedFields = ['id_klien', 'id_jadwal', 'tanggal_kerja', 'deskripsi', 
    'created_at', 'updated_at', 'deleted_at', 'status']; 

    public function getHistoriById($id)
    {
        return $this->db->table('histori')
                        ->select('histori.*, jadwal.nama_produk, jadwal.tanggal as tanggal_kerja, klien.nama_klien')
                        ->join('jadwal', 'histori.id_jadwal = jadwal.id_jadwal', 'left')
                        ->join('klien', 'jadwal.id_klien = klien.id_klien', 'left')
                        ->where('histori.id_histori', $id)
                        ->get()
                        ->getRow();
    }

    public function getHistori()
    {
        return $this->db->table('histori')
                        ->select('histori.*, jadwal.nama_produk, jadwal.tanggal as tanggal_kerja, klien.nama_klien')
                        ->join('jadwal', 'histori.id_jadwal = jadwal.id_jadwal', 'left')
                        ->join('klien', 'jadwal.id_klien = klien.id_klien', 'left')
                        ->get()
                        ->getRow();
    }

    public function tambahHistori($data)
    {
        return $this->insert($data);
    }

    public function tampil()
    {
        return $this->db->table('histori')->get()->getResult(); 
    }

    public function insertHistori($data)
    {
        return $this->insert($data);
    }

    public function getHistoriJoin()
    {
        return $this->db->table('histori')
            ->select('histori.*, jadwal.nama_produk, klien.nama_klien')
            ->join('jadwal', 'jadwal.id_jadwal = histori.id_jadwal')
            ->join('klien', 'klien.id_klien = histori.id_klien')
            ->where('histori.deleted_at', null)
            ->where('histori.status', 0) 
            ->get()
            ->getResult();
    }

    public function softDelete($id)
    {
    	$data = $this->find($id);
    	if ($data) {
    		return $this->update($id, [
    			'status' => 1,
    			'deleted_at' => date('Y-m-d H:i:s'),
    			'deleted_by' => session()->get('id_user')
    		]);
    	}
    	return false;
    }
    public function restore($id)
    {
    	return $this->update($id, [
    		'status' => 0,
    		'deleted_at' => null,
    		'deleted_by' => null
    	]);
    }
    
    public function deletePermanen($id)
    {
        return $this->where('id_histori', $id)->delete();
    }

    public function getDeletedHistori()
    {
        return $this->db->table('histori')
            ->select('histori.*, jadwal.nama_produk, klien.nama_klien')
            ->join('jadwal', 'jadwal.id_jadwal = histori.id_jadwal')
            ->join('klien', 'klien.id_klien = histori.id_klien')
            ->where('histori.deleted_at', null)
            ->where('histori.status', 1) 
            ->get()
            ->getResult();
    }
}