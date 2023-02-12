<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\M_produk;

class Produk extends ResourceController
{
    protected $modelName = 'App\Models\M_produk';
    protected $format    = 'json';

    private function validateApiKey()
    {
        // $api_key = $this->request->getHeaderLine('api_key');
        $api_key = $this->request->getServer('HTTP_API_KEY');

        if ($api_key != getenv('API_KEY')) {
            $response = FALSE;
        } else {
            $response = TRUE;
        }
        return $response;
    }

    public function index()
    {
        if ($this->validateApiKey() == TRUE) {
            $produk = $this->model->findAll();

            if ($produk) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Produk',
                    'data' => $produk
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

    public function produk_kategori($id = null)
    {
        if ($this->validateApiKey() == TRUE) {
            $model = new M_produk();
            if ($id) {
                $data_produk_kategori = $model->get_produk_kategori_show($id);
            } else {
                $data_produk_kategori = $model->get_produk_kategori();
            }
            // $data_produk_kategori = $model->get_produk_kategori();

            if ($data_produk_kategori) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Produk dan Kategori',
                    'data' => $data_produk_kategori
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
            $produk = $this->model->find($id);

            if ($produk) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Produk',
                    'data' => $produk
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
            $data = [
                'kode_produk' => $this->request->getPost('kode_produk'),
                'nama_produk' => $this->request->getPost('nama_produk'),
                'kategori_id' => $this->request->getPost('kategori_id'),
                'harga_modal' => $this->request->getPost('harga_modal'),
                'harga_jual' => $this->request->getPost('harga_jual'),
                'stok' => $this->request->getPost('stok'),
                'gambar' => $this->request->getPost('gambar'),
                'expired_date' => $this->request->getPost('expired_date'),
                'date_created' => date('Y-m-d H:i:s')
            ];

            $createdData = $this->model->insert($data);

            if ($createdData) {
                $response = [
                    'status' => 201,
                    'message' => 'Data created',
                    'data' => $data
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Failed to create data'
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

    public function update($id = null)
    {
        if ($this->validateApiKey() == TRUE) {
            $data = [
                'kode_produk' => $this->request->getPost('kode_produk'),
                'nama_produk' => $this->request->getPost('nama_produk'),
                'kategori_id' => $this->request->getPost('kategori_id'),
                'harga_modal' => $this->request->getPost('harga_modal'),
                'harga_jual' => $this->request->getPost('harga_jual'),
                'stok' => $this->request->getPost('stok'),
                'gambar' => $this->request->getPost('gambar'),
                'expired_date' => $this->request->getPost('expired_date'),
                'date_modified' => date('Y-m-d H:i:s')
            ];

            $updatedData = $this->model->update($id, $data);

            if ($updatedData) {
                $response = [
                    'status' => 200,
                    'message' => 'Data updated',
                    'data' => $data
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Failed to update data'
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

    public function delete($id = null)
    {
        if ($this->validateApiKey() == TRUE) {
            $deletedData = $this->model->delete($id);

            if ($deletedData) {
                $response = [
                    'status' => 204,
                    'message' => 'Data deleted'
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Failed to delete data'
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
