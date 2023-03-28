<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\M_users;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\M_users';
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
            $users = $this->model->findAll();

            if ($users) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Users',
                    'data' => $users
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
            $users = $this->model->find($id);

            if ($users) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Users',
                    'data' => $users
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
            $i = $this->request->getJSON();
            $data = [
                'nama_user' => $i->nama_user,
                'email_user' => $i->email_user,
                'password' => sha1($i->password),
                'role' => $i->role,
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
            $i = $this->request->getJSON();
            $data = [
                'nama_user' => $i->nama_user,
                'email_user' => $i->email_user,
                'password' => sha1($i->password),
                'role' => $i->role,
                'date_created' => date('Y-m-d H:i:s')
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

    public function changepass()
    {
        if ($this->validateApiKey() == TRUE) {
            $i = $this->request->getJSON();
            $model = new M_users();
            $cek = $model->cekpass($i->email, $i->password);

            if ($cek) {
                if ($i->nama_user != null) {
                    $data = [
                        'nama_user' => $i->nama_user,
                        'password' => sha1($i->password_baru),
                    ];
                } else {
                    $data = [
                        'password' => sha1($i->password_baru),
                    ];
                }

                $updatedData = $this->model->update($cek['id_user'], $data);

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
                    'status' => 400,
                    'message' => 'Email atau Password lama salah'
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
