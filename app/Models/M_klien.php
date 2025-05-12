<?php

namespace App\Models;
use CodeIgniter\Model;

class M_klien extends Model {
    protected $table = 'klien';
    protected $primaryKey = 'id_klien';
    protected $allowedFields = ['nama_klien', 'kontak', 'catatan', 'created_at', 'updated_at', 'deleted_at', 'status']; 

    public function softDelete($id)
    {
        return $this->update($id, ['status' => 1]);
    }

    public function restore($id)
    {
        return $this->update($id, ['status' => 0]);
    }

    public function deletePermanen($id)
    {
        return $this->where('id_klien', $id)->delete();
    }

    public function getDeletedKlien()
    {
        return $this->db->table('klien')->where('status', 1)->get()->getResult();
    }

    public function getKlienById($id)
    {
        return $this->db->table('klien')
                        ->where('id_klien', $id)
                        ->get()
                        ->getRow(); 
    }

    public function getKlien()
    {
        return $this->db->table('klien')->where('status', 0)->get()->getResult();
    }

    public function tambahKlien($data)
    {
        return $this->insert($data);
    }

    public function tampil()
    {
        return $this->db->table('klien')->get()->getResult(); 
    }

}