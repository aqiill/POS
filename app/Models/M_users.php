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
}
