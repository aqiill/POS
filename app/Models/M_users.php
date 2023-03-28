<?php

namespace App\Models;

use CodeIgniter\Model;

class M_users extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id_user';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nama_user',
        'email_user',
        'password',
        'role'
    ];

    protected $useTimestamps = false;

    public function cekpass($email, $password)
    {
        $builder = $this->db->table('users');
        $builder->where(['email_user' => $email, 'password' => sha1($password)]);
        $query = $builder->get();
        return $query->getRowArray();
    }
}
