<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\M_transaksi;
use App\Models\M_produk;

class Transaksi extends ResourceController
{
    protected $modelName = 'App\Models\M_transaksi';
    protected $format    = 'json';

    private function validateApiKey()
    {
        // $api_key = $this->request->getHeaderLine('api_key');
        $api_key = $this->request->getServer('HTTP_API_KEY');

        if ($api_key === getenv('API_KEY')) {
            $response = TRUE;
        } else {
            $response = FALSE;
        }
        return $response;
    }

    public function index()
    {
        if ($this->validateApiKey() == TRUE) {
            // $transaksi = $this->model->findAll();
            $model = new M_transaksi();
            $transaksi = $model->get_transaksi();

            if ($transaksi) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Transaksi',
                    'data' => $transaksi
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found'
                ];

                return $this->response->setJSON($response);
            }
        } else {
            $response = [
                'status' => 401,
                'message' => 'API Key tidak ditemukan.'
            ];
            return $this->response->setJSON($response);
        }
    }

    public function show($id = null)
    {
        if ($this->validateApiKey() == TRUE) {
            // $transaksi = $this->model->find($id);
            $model = new M_transaksi();
            $transaksi = $model->get_transaksi_show($id);

            if ($transaksi) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Transaksi',
                    'data' => $transaksi
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found'
                ];

                return $this->response->setJSON($response);
            }
        } else {
            $response = [
                'status' => 401,
                'message' => 'API Key tidak ditemukan.'
            ];
            return $this->response->setJSON($response);
        }
    }

    public function create()
    {
        if ($this->validateApiKey() == TRUE) {
            $model = new M_transaksi();
            $model_produk = new M_produk();
            $i = $this->request->getJSON();

            foreach ($i->detail as $item) {
                $produk = $model_produk->get_produk_kategori_show($item->id_produk);
                foreach ($produk as $value) {
                    $kurangi = $value['stok'] - $item->jml_pesan;
                    if ($value['stok'] < $item->jml_pesan) {
                        $response[] = [
                            'status' => 400,
                            'message' => 'Stok ' . $value['nama_produk'] . ' tidak mencukupi sebanyak ' . $item->jml_pesan
                        ];
                    } else {
                        $response = null;
                        $update_stok = $model_produk->update($value['produk_id'], ['stok' => $kurangi]);
                    }
                }
            }

            if ($response != null) {
                return $this->response->setJSON($response);
            }

            $data_pembayaran = [
                'id_user'   => $i->id_user,
                'total_pembayaran'  => $i->total_pembayaran,
                'total_diskon'  => $i->total_diskon,
                'no_pembayaran' => $i->no_pembayaran,
                'status_bayar' => $i->status_bayar,
            ];

            $created_pembayaran = $model->create('pembayaran', $data_pembayaran);
            $id_pembayaran = $this->model->insertID();

            foreach ($i->detail as $key => $value) {
                $data_detail[] = [
                    'id_produk' => $value->id_produk,
                    'id_pembayaran' => $id_pembayaran,
                    'jml_pesan' => $value->jml_pesan
                ];
            }

            $created_detail = $this->model->insertBatch($data_detail);

            if ($created_pembayaran != "" || $created_detail != "") {
                $response = [
                    'status' => 201,
                    'message' => 'Transaksi berhasil'
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Transaksi gagal'
                ];

                return $this->response->setJSON($response);
            }
        } else {
            $response = [
                'status' => 401,
                'message' => 'API Key tidak ditemukan.'
            ];
            return $this->response->setJSON($response);
        }
    }

    public function best_selling()
    {
        if ($this->validateApiKey() == TRUE) {
            $model = new M_transaksi();
            $best_selling = $model->best_selling();

            if ($best_selling) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Best Selling',
                    'data' => $best_selling
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found'
                ];

                return $this->response->setJSON($response);
            }
        } else {
            $response = [
                'status' => 401,
                'message' => 'API Key tidak ditemukan.'
            ];
            return $this->response->setJSON($response);
        }
    }

    // public function update($id = null)
    // {
    //     if ($this->validateApiKey() == TRUE) {
    //         $i = $this->request->getJSON();
    //         $data = [
    //             'kode_produk' => $i->kode_produk,
    //             'nama_produk' => $i->nama_produk,
    //             'kategori_id' => $i->kategori_id,
    //             'harga_modal' => $i->harga_modal,
    //             'harga_jual' => $i->harga_jual,
    //             'stok' => $i->stok,
    //             'gambar' => $i->gambar,
    //             'date_modified' => date('Y-m-d H:i:s')
    //         ];

    //         $updatedData = $this->model->update($id, $data);

    //         if ($updatedData) {
    //             $response = [
    //                 'status' => 200,
    //                 'message' => 'Data updated',
    //                 'data' => $data
    //             ];

    //             return $this->response->setJSON($response);
    //         } else {
    //             $response = [
    //                 'status' => 400,
    //                 'message' => 'Failed to update data'
    //             ];

    //             return $this->response->setJSON($response);
    //         }
    //     } else {
    //         $response = [
    //             'status' => 401,
    //             'message' => 'API Key tidak ditemukan.'
    //         ];
    //         return $this->response->setJSON($response);
    //     }
    // }

    // public function delete($id_produk = null)
    // {
    //     if ($this->validateApiKey() == TRUE) {
    //         $deletedData = $this->model->delete($id);

    //         if ($deletedData) {
    //             $response = [
    //                 'status' => 204,
    //                 'message' => 'Data deleted'
    //             ];

    //             return $this->response->setJSON($response);
    //         } else {
    //             $response = [
    //                 'status' => 400,
    //                 'message' => 'Failed to delete data'
    //             ];

    //             return $this->response->setJSON($response);
    //         }
    //     } else {
    //         $response = [
    //             'status' => 401,
    //             'message' => 'API Key tidak ditemukan.'
    //         ];
    //         return $this->response->setJSON($response);
    //     }
    // }

    public function pendapatan()
    {
        if ($this->validateApiKey() == TRUE) {
            $model = new M_transaksi();
            $model_produk = new M_produk();

            $total_transaksi = $model->total_transaksi();
            $total_pendapatan = $model->total_pendapatan();
            $total_harian = $model->total_harian();
            $total_profit = $model_produk->total_profit();

            if ($total_pendapatan != "" && $total_harian != "") {
                $response = [
                    'status' => 200,
                    'message' => 'Data Pendapatan',
                    'data' => [
                        'total_transaksi' => $total_transaksi['total'],
                        'total_pendapatan' => $total_pendapatan['total'],
                        'total_profit' => $total_profit['total_keuntungan'],
                        'total_harian' => $total_harian['total']
                    ]
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found'
                ];

                return $this->response->setJSON($response);
            }
        } else {
            $response = [
                'status' => 401,
                'message' => 'API Key tidak ditemukan.'
            ];
            return $this->response->setJSON($response);
        }
    }

    public function riwayat_transaksi()
    {
        if ($this->validateApiKey() == TRUE) {
            $model = new M_transaksi();
            $riwayat_transaksi = $model->riwayat_transaksi();

            if ($riwayat_transaksi) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Riwayat Transaksi',
                    'data' => $riwayat_transaksi
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found'
                ];

                return $this->response->setJSON($response);
            }
        } else {
            $response = [
                'status' => 401,
                'message' => 'API Key tidak ditemukan.'
            ];
            return $this->response->setJSON($response);
        }
    }
}
