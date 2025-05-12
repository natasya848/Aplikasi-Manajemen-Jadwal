<?php

namespace App\Models;
use CodeIgniter\Model;

class M_log extends Model {
	protected $table = 'log_activity';
    protected $primaryKey = 'id_log';
    protected $allowedFields = ['id_user', 'aktivitas', 'ip_address', 'waktu'];
    protected $returnType = 'object';

    public function saveLog($id_user, $aktivitas, $ip_address) {
        return $this->insert([
            'id_user'   => $id_user,
            'aktivitas' => $aktivitas,
            'ip_address'=> $ip_address
        ]);
    }

    public function getLogs() 
    {
        $this->db->select('log_activity.*, user.username, user.nama AS nama_user');
        $this->db->from('log_activity');
        $this->db->join('user', 'user.id_user = log_activity.id_user');
        $this->db->order_by('waktu', 'DESC');
        return $this->findAll();
    }

    public function getAllLogs()
    {
        return $this->db->table('log_activity')
            ->join('user', 'user.id_user = log_activity.id_user', 'LEFT')
            ->select('log_activity.*, user.nama_user, user.username')
            ->orderBy('waktu', 'DESC')
            ->get()
            ->getResult();
    }

    public function getLogsByUser($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }

}