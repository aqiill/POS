<?php

namespace App\Models;

use CodeIgniter\Model;

class M_member extends Model
{
    protected $table      = 'member';
    protected $primaryKey = 'id_member';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nama_member',
        'no_whatsapp',
        'email_member',
        'status_member',
        'no_member'
    ];

    protected $useTimestamps = false;
}
