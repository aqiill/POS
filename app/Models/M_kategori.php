<?php

namespace App\Models;

use CodeIgniter\Model;

class M_kategori extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'kategori_id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nama_kategori',
        'date_created',
        'date_modified'
    ];

    protected $useTimestamps = false;
}
