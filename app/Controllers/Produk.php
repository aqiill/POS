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
                    'message' => 'Data not found',
                    'data' => []
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
                    'message' => 'Data not found',
                    'data' => []
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

    public function stok()
    {
        $model = new M_produk();
        if ($this->validateApiKey() == TRUE) {
            $produk = $model->stok();

            if ($produk) {
                $response = [
                    'status' => 200,
                    'message' => 'Stock Alert',
                    'data' => $produk
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found',
                    'data' => []
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

    public function expired()
    {
        $model = new M_produk();
        if ($this->validateApiKey() == TRUE) {
            $produk = $model->expired();

            if ($produk) {
                $response = [
                    'status' => 200,
                    'message' => 'Expired Soon',
                    'data' => $produk
                ];

                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found',
                    'data' => []
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
            $produk_by_code = $this->model->where('kode_produk', $id)->first();

            if ($produk) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Produk',
                    'data' => $produk
                ];
                return $this->response->setJSON($response);
            } else if ($produk_by_code) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Produk',
                    'data' => $produk_by_code
                ];
                return $this->response->setJSON($response);
            } else {
                $response = [
                    'status' => 404,
                    'message' => 'Data not found',
                    'data' => []
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
            $i = $this->request;
            //validate input
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'kode_produk' => 'required|is_unique[produk.kode_produk]',
                'nama_produk' => 'required',
                'kategori_id' => 'required',
                'harga_modal' => 'required',
                'harga_jual' => 'required',
                'stok' => 'required',
                'gambar' => 'uploaded[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
                'expired_date' => 'required'
            ]);
            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $response = [
                    'status' => 400,
                    'message' => 'Data not valid',
                    'data' => $validation->getErrors()
                ];

                return $this->response->setJSON($response);
            } else {
                $gambar = $this->request->getFile('gambar');
                $date = date('YmdHis');
                $newName = $date . '_' . $gambar->getName();

                $gambar->move(FCPATH . 'assets/product', $newName);

                $data = [
                    'kode_produk' => $i->getPost('kode_produk'),
                    'nama_produk' => $i->getPost('nama_produk'),
                    'kategori_id' => $i->getPost('kategori_id'),
                    'harga_modal' => $i->getPost('harga_modal'),
                    'harga_jual' => $i->getPost('harga_jual'),
                    'stok' => $i->getPost('stok'),
                    'gambar' => $newName,
                    'expired_date' => $i->getPost('expired_date'),
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
            $i = $this->request;

            //validate input
            $validation =  \Config\Services::validation();
            $validation->setRules([
                'kode_produk' => 'required',
                'nama_produk' => 'required',
                'kategori_id' => 'required',
                'harga_modal' => 'required',
                'harga_jual' => 'required',
                'stok' => 'required',
                // 'gambar' => 'mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,1024]',
                'expired_date' => 'required'
            ]);
            $validation->withRequest($this->request)->run();

            if ($validation->getErrors()) {
                $response = [
                    'status' => 400,
                    'message' => 'Data not valid',
                    'data' => $validation->getErrors()
                ];

                return $this->response->setJSON($response);
            } else {
                $gambar = $this->request->getFile('gambar');

                if ($gambar == null) {
                    $data = [
                        'kode_produk' => $i->getPost('kode_produk'),
                        'nama_produk' => $i->getPost('nama_produk'),
                        'kategori_id' => $i->getPost('kategori_id'),
                        'harga_modal' => $i->getPost('harga_modal'),
                        'harga_jual' => $i->getPost('harga_jual'),
                        'stok' => $i->getPost('stok'),
                        'expired_date' => $i->getPost('expired_date'),
                        'date_updated' => date('Y-m-d H:i:s')
                    ];
                } else {
                    $date = date('YmdHis');
                    $newName = $date . '_' . $gambar->getName();

                    $gambar->move(FCPATH . 'assets/product', $newName);
                    $data = [
                        'kode_produk' => $i->getPost('kode_produk'),
                        'nama_produk' => $i->getPost('nama_produk'),
                        'kategori_id' => $i->getPost('kategori_id'),
                        'harga_modal' => $i->getPost('harga_modal'),
                        'harga_jual' => $i->getPost('harga_jual'),
                        'stok' => $i->getPost('stok'),
                        'gambar' => $newName,
                        'expired_date' => $i->getPost('expired_date'),
                        'date_updated' => date('Y-m-d H:i:s')
                    ];
                    $oldFile = $this->model->find($id);
                    if ($oldFile['gambar'] != '') {
                        unlink(FCPATH . 'assets/product/' . $oldFile['gambar']);
                    }
                }

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
            //unlink gambar
            $oldFile = $this->model->find($id);
            if ($oldFile['gambar'] != '') {
                unlink(FCPATH . 'assets/product/' . $oldFile['gambar']);
            }

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
