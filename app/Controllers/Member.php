<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Member extends ResourceController
{
    protected $modelName = 'App\Models\M_member';
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
            $member = $this->model->findAll();

            if ($member) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Member',
                    'data' => $member
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
            $member = $this->model->find($id);

            if ($member) {
                $response = [
                    'status' => 200,
                    'message' => 'Data Member',
                    'data' => $member
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
            $i = $this->request->getJSON();
            //validate input json
            if ($i->nama_member == null || $i->no_whatsapp == null || $i->email_member == null || $i->status_member == null || $i->no_member == null) {
                $response = [
                    'status' => 400,
                    'message' => 'Failed to create data, input data is not complete'
                ];

                return $this->response->setJSON($response);
            }

            $data = [
                'nama_member' => $i->nama_member,
                'no_whatsapp' => $i->no_whatsapp,
                'email_member' => $i->email_member,
                'status_member' => $i->status_member,
                'no_member' => $i->no_member
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
            //validate input json
            if ($i->nama_member == null || $i->no_whatsapp == null || $i->email_member == null || $i->status_member == null || $i->no_member == null) {
                $response = [
                    'status' => 400,
                    'message' => 'Failed to update data, input data is not complete'
                ];

                return $this->response->setJSON($response);
            }

            $data = [
                'nama_member' => $i->nama_member,
                'no_whatsapp' => $i->no_whatsapp,
                'email_member' => $i->email_member,
                'status_member' => $i->status_member,
                'no_member' => $i->no_member
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
