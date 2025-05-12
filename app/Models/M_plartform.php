<?php

namespace App\Models;
use CodeIgniter\Model;

class M_plartform extends Model {
    protected $table = 'plartform';
    protected $primaryKey = 'id_plartform';
    protected $allowedFields = ['nama_plartform', 'tarif', 'created_at', 'updated_at', 'deleted_at', 'status']; 

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
        return $this->where('id_plartform', $id)->delete();
    }

    public function getDeletedPlartform()
    {
        return $this->db->table('plartform')->where('status', 1)->get()->getResult();
    }

    public function getPlartformById($id)
    {
        return $this->db->table('plartform')
                        ->where('id_plartform', $id)
                        ->get()
                        ->getRow(); 
    }

    public function getPlartform()
    {
        return $this->db->table('plartform')->where('status', 0)->get()->getResult();
    }

    public function tambahPlartform($data)
    {
        return $this->insert($data);
    }
}