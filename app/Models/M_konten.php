<?php

namespace App\Models;
use CodeIgniter\Model;

class M_konten extends Model {
    protected $table = 'konten';
    protected $primaryKey = 'id_konten';
    protected $allowedFields = ['judul', 'plartform', 'deadline', 'id_jadwal', 'nama_produk', 'nama_klien', 'url_file',
     'created_at', 'updated_at', 'deleted_at', 'status', 'statusr']; 

    public function getKontenById($id)
    {
        return $this->db->table('konten')
                        ->select('konten.*, GROUP_CONCAT(plartform.nama_plartform SEPARATOR ", ") as plartform, jadwal.nama_produk, klien.nama_klien, jadwal.tanggal')
                        ->join('konten_plartform', 'konten.id_konten = konten_plartform.id_konten', 'left')
                        ->join('plartform', 'konten_plartform.id_plartform = plartform.id_plartform', 'left')
                        ->join('jadwal', 'konten.id_jadwal = jadwal.id_jadwal', 'left')
                        ->join('klien', 'jadwal.id_klien = klien.id_klien', 'left')
                        ->groupBy('konten.id_konten')
                        ->where('konten.id_konten', $id) 
                        ->get()
                        ->getRow();
    }

    public function getKontenWithPlartform()
    {
        return $this->db->table('konten')
                        ->select('konten.*, GROUP_CONCAT(plartform.nama_plartform SEPARATOR ", ") as plartform, jadwal.nama_produk, klien.nama_klien, jadwal.tanggal')
                        ->join('konten_plartform', 'konten.id_konten = konten_plartform.id_konten', 'left')
                        ->join('plartform', 'konten_plartform.id_plartform = plartform.id_plartform', 'left')
                        ->join('jadwal', 'konten.id_jadwal = jadwal.id_jadwal', 'left') 
                        ->join('klien', 'jadwal.id_klien = klien.id_klien', 'left')
                        ->groupBy('konten.id_konten')
                        ->where('konten.statusr', 0)
                        ->get()
                        ->getResult();
    }

    public function tambahKonten($data)
    {
        return $this->insert($data);
    }

    public function getJadwalWithProdukKonten() {
        return $this->db->table('jadwal')
            ->select('jadwal.id_jadwal, jadwal.nama_produk, jadwal.tanggal, klien.nama_klien')
            ->join('klien', 'klien.id_klien = jadwal.id_klien')
            ->where('jadwal.status', 'Terjadwal')
            ->get()
            ->getResult();
    }

    public function getPlatform()
    {
        return $this->db->table('plartform')->get()->getResult();
    }

    public function getPlatformByKontenId($id)
    {
        return $this->db->table('konten_plartform')
            ->select('id_plartform') 
            ->where('id_konten', $id)
            ->get()
            ->getResult();
    }

    public function getPlatformByKonten($id_konten)
    {
        return $this->db->table('konten_plartform')
                        ->select('plartform.tarif, plartform.nama_plartform')
                        ->join('plartform', 'konten_plartform.id_plartform = plartform.id_plartform', 'left')
                        ->where('konten_plartform.id_konten', $id_konten)
                        ->get()
                        ->getResult();
    }

    public function removePlatformFromKonten($id_konten, array $ids)
    {
        $this->db->table('konten_plartform')
            ->where('id_konten',$id_konten)
            ->whereIn('id_plartform',$ids)
            ->delete();
    }

    public function addPlatformToKonten($id_konten, array $ids)
    {
        $batch = [];
        foreach ($ids as $pid) {
            $batch[] = ['id_konten'=>$id_konten,'id_plartform'=>$pid];
        }
        $this->db->table('konten_plartform')->insertBatch($batch);
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
        return $this->where('id_konten', $id)->delete();
    }

    public function getDeletedKonten()
    {
        return $this->db->table('konten')
                        ->select('konten.*, GROUP_CONCAT(plartform.nama_plartform SEPARATOR ", ") as plartform, jadwal.nama_produk, klien.nama_klien, jadwal.tanggal')
                        ->join('konten_plartform', 'konten.id_konten = konten_plartform.id_konten', 'left')
                        ->join('plartform', 'konten_plartform.id_plartform = plartform.id_plartform', 'left')
                        ->join('jadwal', 'konten.id_jadwal = jadwal.id_jadwal', 'left') 
                        ->join('klien', 'jadwal.id_klien = klien.id_klien', 'left')
                        ->groupBy('konten.id_konten')
                        ->where('konten.statusr', 1)
                        ->get()
                        ->getResult();
    }

    public function getActiveContents()
    {
        $today = date('Y-m-d');
        $twoDaysLater = date('Y-m-d', strtotime('+2 days'));
    
        return $this->where('DATE(deadline) >=', $today)
                    ->where('DATE(deadline) <=', $twoDaysLater)
                    ->whereNotIn('status', ['Proses', 'Revisi'])
                    ->orderBy('deadline')
                    ->findAll();
    }
        

}