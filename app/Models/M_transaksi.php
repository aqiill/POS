<?php

namespace App\Models;

use CodeIgniter\Model;

class M_transaksi extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_produk',
        'id_pembayaran',
        'jml_pesan'
    ];

    protected $useTimestamps = false;

    public function get_transaksi()
    {
        return $this->db->table('pembayaran')
            ->select('*')
            ->join('users', 'users.id_user = pembayaran.id_user')
            ->get()->getResultArray();
    }

    public function get_transaksi_show($id = null)
    {
        return $this->db->table('transaksi')
            ->select('*')
            ->join('pembayaran', 'transaksi.id_pembayaran = pembayaran.id_pembayaran')
            ->where('pembayaran.id_pembayaran', $id)
            ->get()->getResultArray();
    }

    public function create($table, $data)
    {
        $query = $this->db->table($table)->insert($data);
    }
    // public function get_produk_kategori()
    // {
    //     return $this->db->table('produk')
    //         ->select('*')
    //         ->join('kategori', 'kategori.kategori_id = produk.kategori_id')
    //         ->get()->getResultArray();
    // }

    // public function get_produk_kategori_show($id = null)
    // {
    //     return $this->db->table('produk')
    //         ->select('*')
    //         ->join('kategori', 'kategori.kategori_id = produk.kategori_id')
    //         ->where('produk_id', $id)
    //         ->get()->getResultArray();
    // }
}
