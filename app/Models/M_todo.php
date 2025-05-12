<?php

namespace App\Models;

use CodeIgniter\Model;

class M_todo extends Model
{
    protected $table = 'todo';
    protected $primaryKey = 'id_todo';
    protected $allowedFields = ['tanggal', 'kegiatan', 'status', 'prioritas', 'id_klien', 'id_jadwal', 
    'created_at', 'updated_at', 'statusr'];
    protected $returnType    = 'object'; 

    public function getAllTodo()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function addTodo($data)
    {
        return $this->insert($data);
    }

    public function updateStatusTodo($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    public function getTodoById($id)
    {
        return $this->find($id);
    }

    public function deleteTodoById($id)
    {
        return $this->delete($id);
    }

    public function updateStatusByJadwal(int $idJadwal, string $newStatus)
    {
        return $this->where('id_jadwal', $idJadwal)
                    ->set([
                        'status'     => $newStatus,
                        'updated_at' => date('Y-m-d H:i:s')
                    ])
                    ->update();
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
        return $this->where('id_todo', $id)->delete();
    }

    public function getDeletedTodo()
    {
        return $this->db->table('todo')->where('statusr', 1)->get()->getResult();
    }

    public function getHighPriorityTasks()
    {
        return $this->where('status !=', 'Selesai', 'Proses')
                    ->where('statusr', 0)
                    ->orderBy('tanggal')
                    ->findAll();
    }

}
