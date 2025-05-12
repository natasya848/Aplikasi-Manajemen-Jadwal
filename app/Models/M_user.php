<?php

namespace App\Models;
use CodeIgniter\Model;

class M_user extends Model {
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama_user', 'username', 'email', 'password', 'level', 'created_at', 'updated_at', 'deleted_at', 'status', 'foto', 'no_hp']; 

    public function getRecentActivities($id_user)
    {
        return $this->db->table('log_activity')
            ->where('id_user', $id_user)
            ->orderBy('waktu', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();
    }

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
        return $this->where('id_user', $id)->delete();
    }

    public function getDeletedUser()
    {
        return $this->db->table('user')->where('status', 1)->get()->getResult();
    }

    public function getUserById($id)
    {
        return $this->db->table('user')
                        ->where('id_user', $id)
                        ->get()
                        ->getRow(); 
    }

    public function getUser()
    {
        return $this->db->table('user')->where('status', 0)->get()->getResult();
    }

    public function tambahUser($data)
    {
        return $this->insert($data);
    }
}
