<?php

namespace App\Models;
use CodeIgniter\Model;

class M_jadwal extends Model {
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['nama_produk', 'id_klien', 'tanggal', 'jam', 'status', 'catatan', 
    'pengingat', 'created_at', 'updated_at', 'deleted_at', 'statusr']; 

    public function getJadwalById($id)
    {
        return $this->db->table('jadwal')
                        ->select('jadwal.*, klien.nama_klien')
                        ->join('klien', 'klien.id_klien = jadwal.id_klien')
                        ->where('id_jadwal', $id)
                        ->get()
                        ->getRow(); 
    }

    public function getJadwal()
    {
        return $this->db->table('jadwal')
            ->select('jadwal.*, klien.nama_klien')
            ->join('klien', 'klien.id_klien = jadwal.id_klien')
            ->where('statusr', 0)
            ->get()
            ->getResult();
    }

    public function tambahJadwal($data)
    {
        return $this->insert($data);
    }

    public function getLaporanJadwal($start = null, $end = null)
    {
        $builder = $this->db->table('jadwal j');
        $builder->select("
            j.tanggal,
            j.nama_produk,
            j.jam,
            k.judul,
            k.deadline,
            j.status AS status_jadwal,
            k.status AS status_konten,
            GROUP_CONCAT(DISTINCT p.nama_plartform SEPARATOR ', ') AS platform
        ");
        $builder->join('konten k', 'j.id_jadwal = k.id_jadwal', 'left');
        $builder->join('konten_plartform kp', 'k.id_konten = kp.id_konten', 'left');
        $builder->join('plartform p', 'kp.id_plartform = p.id_plartform', 'left');

        if ($start && $end) {
            $builder->where('j.tanggal >=', $start);
            $builder->where('j.tanggal <=', $end);
        }

        $builder->where('j.status', 'Selesai');
        $builder->groupBy('j.id_jadwal');
        $builder->orderBy('j.tanggal', 'ASC');

        return $builder->get()->getResult();
    }

    public function softDelete($id)
    {
        return $this->update($id, ['statusr' => 1]);
    }

    public function restore($id)
    {
        return $this->update($id, ['statusr' => 0]);
    }

    public function deletePermanen($id)
    {
        return $this->where('id_jadwal', $id)->delete();
    }

    public function getDeletedJadwal()
    {
        return $this->db->table('jadwal')
        ->select('jadwal.*, klien.nama_klien')
        ->join('klien', 'klien.id_klien = jadwal.id_klien')
        ->where('statusr', 1)
        ->get()
        ->getResult();
    }

    public function getTodaySchedule()
    {
        return $this->where('tanggal', date('Y-m-d'))->orderBy('jam')->findAll();
    }

    public function getUpcomingReminder()
    {
        return $this->where('pengingat >=', date('Y-m-d H:i:s'))
                    ->orderBy('pengingat', 'ASC')
                    ->first();
    }


}