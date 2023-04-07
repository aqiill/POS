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

    public function stok()
    {
        return $this->db->table('produk')
            ->select('*')
            ->where('stok <=', '100')
            ->get()->getResultArray();
    }

    public function expired()
    {
        return $this->db->table('produk')
            ->select('*')
            ->where('DATEDIFF(expired_date, CURDATE()) <=', 180)
            ->get()->getResultArray();
    }

    public function total_profit()
    {
        $builder = $this->db->table('transaksi t');
        $builder->select('p.nama_produk, SUM(t.jml_pesan) AS total_terjual, SUM((t.jml_pesan * p.harga_jual) - (t.jml_pesan * p.harga_modal)) AS keuntungan, (SELECT SUM((t.jml_pesan * p.harga_jual) - (t.jml_pesan * p.harga_modal)) FROM transaksi t INNER JOIN produk p ON t.id_produk = p.produk_id INNER JOIN pembayaran pb ON t.id_pembayaran = pb.id_pembayaran WHERE pb.status_bayar = "Y") AS total_keuntungan');
        $builder->join('produk p', 't.id_produk = p.produk_id');
        $builder->join('pembayaran pb', 't.id_pembayaran = pb.id_pembayaran');
        $builder->where('pb.status_bayar', 'Y');
        $builder->groupBy('p.nama_produk');
        $builder->orderBy('keuntungan', 'DESC');

        return $builder->get();
    }
}
