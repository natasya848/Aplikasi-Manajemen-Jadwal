<?php

namespace App\Models;
use CodeIgniter\Model;

class M_role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $allowedFields = ['nama_role'];
}
