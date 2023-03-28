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
            ->where('pembayaran.status_bayar', 'Y')
            ->get()->getResultArray();
    }

    public function get_transaksi_today()
    {
        $query = $this->db->table('pembayaran')
            ->select('*')
            ->join('users', 'users.id_user = pembayaran.id_user')
            ->join('transaksi', 'transaksi.id_pembayaran = pembayaran.id_pembayaran')
            ->join('produk', 'produk.produk_id = transaksi.id_produk')
            ->where('pembayaran.status_bayar', 'Y')
            ->where('DATE_FORMAT(tgl_pembayaran, "%Y-%m-%d")', date('Y-m-d'))
            ->get()
            ->getResultArray();

        $grouped = [];

        foreach ($query as $row) {
            $id_pembayaran = $row['id_pembayaran'];

            if (!isset($grouped[$id_pembayaran])) {
                $grouped[$id_pembayaran] = [
                    'id_pembayaran' => $row['id_pembayaran'],
                    'id_user' => $row['id_user'],
                    'total_pembayaran' => $row['total_pembayaran'],
                    'total_diskon' => $row['total_diskon'],
                    'no_pembayaran' => $row['no_pembayaran'],
                    'status_bayar' => $row['status_bayar'],
                    'tgl_pembayaran' => $row['tgl_pembayaran'],
                    'nama_user' => $row['nama_user'],
                    'email_user' => $row['email_user'],
                    'password' => $row['password'],
                    'role' => $row['role'],
                    'pembelian' => []
                ];
            }

            $grouped[$id_pembayaran]['pembelian'][] = [
                'id_transaksi' => $row['id_transaksi'],
                'id_produk' => $row['id_produk'],
                'nama_produk' => $row['nama_produk'],
                'harga_jual' => $row['harga_jual'],
                'id_pembayaran' => $row['id_pembayaran'],
                'jml_pesan' => $row['jml_pesan']
            ];
        }

        return array_values($grouped);
    }

    public function get_transaksi_show($id = null)
    {
        return $this->db->table('transaksi')
            ->select('*')
            // ->join('pembayaran', 'transaksi.id_pembayaran = pembayaran.id_pembayaran')
            ->where('id_pembayaran', $id)
            ->get()->getResultArray();
    }

    public function create($table, $data)
    {
        $query = $this->db->table($table)->insert($data);
    }

    public function best_selling()
    {
        return $this->db->table('transaksi')
            ->select('produk.nama_produk, SUM(transaksi.jml_pesan) as total')
            ->join('produk', 'produk.produk_id = transaksi.id_produk')
            ->groupBy('produk.nama_produk')
            ->orderBy('total', 'DESC')
            ->limit(3)
            ->get()->getResultArray();
    }

    public function total_pendapatan()
    {
        return $this->db->table('pembayaran')
            ->select('SUM(pembayaran.total_pembayaran) as total')
            ->get()->getRowArray();
    }

    public function total_harian()
    {
        return $this->db->table('pembayaran')
            ->select('SUM(pembayaran.total_pembayaran) as total')
            ->where('DATE_FORMAT(tgl_pembayaran, "%Y-%m-%d")', date('Y-m-d'))
            ->get()->getRowArray();
    }

    public function riwayat_transaksi()
    {
        return $this->db->table('pembayaran')
            ->select('pembayaran.*, users.nama_user')
            ->join('users', 'users.id_user = pembayaran.id_user')
            ->get()->getResultArray();
    }

    public function total_transaksi()
    {
        return $this->db->table('pembayaran')
            ->select('COUNT(pembayaran.id_pembayaran) as total')
            ->where('pembayaran.status_bayar', 'Y')
            ->get()->getRowArray();
    }
}
