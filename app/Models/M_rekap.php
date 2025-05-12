<?php

namespace App\Models;

use CodeIgniter\Model;

class M_rekap extends Model
{
    protected $table = 'rekap_keuangan';
    protected $primaryKey = 'id_rekap';
    protected $allowedFields = ['tanggal', 'jenis', 'kategori', 'jumlah', 'deskripsi', 
    'created_at', 'updated_at', 'deleted_at', 'status'];

    public function getAll()
    {
        return $this->db->table('rekap_keuangan')
                        ->orderBy('tanggal', 'DESC')
                        ->where('status', 0)
                        ->get()
                        ->getResult();
    }

    public function getById($id)
    {
        return $this->db->table('rekap_keuangan')
                        ->where('id_rekap', $id)
                        ->get()
                        ->getRow();
    }

    public function insertRekap($data)
    {
        return $this->insert($data);
    }

    public function getLaporan($startDate = null, $endDate = null)
    {
        $builder = $this->db->table($this->table);

        if ($startDate && $endDate) {
            $builder->where('tanggal >=', $startDate)
                    ->where('tanggal <=', $endDate);
        }

        return $builder->orderBy('tanggal', 'ASC')->get()->getResult();
    }

    public function getSummary($startDate = null, $endDate = null)
    {
        $builder = $this->builder();

        if ($startDate && $endDate) {
            $builder->where('tanggal >=', $startDate)
                    ->where('tanggal <=', $endDate);
        }

        $data = $builder->select('jenis, SUM(jumlah) as total')
                        ->groupBy('jenis')
                        ->get()
                        ->getResult();

        $summary = [
            'pemasukan' => 0,
            'pengeluaran' => 0,
            'saldo' => 0,
        ];

        foreach ($data as $row) {
            $jenis = strtolower($row->jenis);

            if ($jenis == 'pemasukan' || $jenis == 'pemasukkan') {
                $summary['pemasukan'] += $row->total;
            } elseif ($jenis == 'pengeluaran') {
                $summary['pengeluaran'] += $row->total;
            }

        }

        $summary['saldo'] = $summary['pemasukan'] - $summary['pengeluaran'];

        return $summary;
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
        return $this->where('id_rekap', $id)->delete();
    }

    public function getDeletedRekap()
    {
        return $this->db->table('rekap_keuangan')->where('status', 1)->get()->getResult();
    }

    public function getTotal($jenis)
    {
        return $this->selectSum('jumlah')
                    ->where('jenis', $jenis)
                    ->first()['jumlah'];
    }
}
