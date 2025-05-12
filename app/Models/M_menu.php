<?php
namespace App\Models;
use CodeIgniter\Model;

class M_menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    protected $allowedFields = ['nama_menu', 'url', 'icon', 'is_parent', 'parent_id', 'urutan'];

    public function getMenuByRole($id_role)
    {
        return $this->db->table('menu m')
            ->select('m.*')
            ->join('role_menu a', 'a.id_menu = m.id_menu')
            ->where('a.id_role', $id_role)
            ->where('a.can_view', 1)  
            ->orderBy('m.parent_id', 'ASC')
            ->orderBy('m.urutan', 'ASC')
            ->get()
            ->getResult();
    }
}
