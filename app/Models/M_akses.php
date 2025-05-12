<?php
namespace App\Models;
use CodeIgniter\Model;

class M_akses extends Model
{
    protected $table = 'role_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_role', 'id_menu', 'can_view', 'can_add', 'can_edit', 'can_delete'];

    public function getAksesByRoleAndMenu($id_role, $id_menu)
    {
        return $this->where('id_role', $id_role)
                    ->where('id_menu', $id_menu)
                    ->first();
    }

    public function deleteByRole($id_role)
    {
        return $this->where('id_role', $id_role)->delete();
    }

    public function getByRole($id_role)
    {
        return $this->where('id_role', $id_role)->findAll();
    }
}
