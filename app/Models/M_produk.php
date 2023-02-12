<?php

namespace App\Models;

use CodeIgniter\Model;

class M_produk extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'produk_id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'kode_produk',
        'nama_produk',
        'kategori_id',
        'harga_modal',
        'harga_jual',
        'stok',
        'gambar',
        'expired_date',
        'date_created',
        'date_modified'
    ];

    protected $useTimestamps = false;

    public function get_produk_kategori()
    {
        return $this->db->table('produk')
            ->select('*')
            ->join('kategori', 'kategori.kategori_id = produk.kategori_id')
            ->get()->getResultArray();
    }

    public function get_produk_kategori_show($id = null)
    {
        return $this->db->table('produk')
            ->select('*')
            ->join('kategori', 'kategori.kategori_id = produk.kategori_id')
            ->where('produk_id', $id)
            ->get()->getResultArray();
    }
}
