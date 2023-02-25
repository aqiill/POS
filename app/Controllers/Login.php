<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\M_login;

class Login extends Controller
{
    public function auth()
    {
        $api_key = $this->request->getServer('HTTP_API_KEY');

        if ($api_key === getenv('API_KEY')) {
            $i = $this->request->getJSON();
            $email_user = $i->email_user;
            $password = $i->password;

            $model = new M_login();
            $user = $model->validate_user($email_user, $password);

            if ($user) {
                $response = [
                    'status' => 200,
                    'message' => 'Login Berhasil',
                    'data' => $user
                ];
            } else {
                $response = [
                    'status' => 401,
                    'message' => 'Email atau password salah'
                ];
            }

            return $this->response->setJSON($response);
        } else {
            $response = [
                'status' => 401,
                'message' => 'API Key tidak ditemukan.'
            ];
            return $this->response->setJSON($response);
        }
    }
}
