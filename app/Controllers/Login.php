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

    public function forgot()
    {
        $api_key = $this->request->getServer('HTTP_API_KEY');
        if ($api_key === getenv('API_KEY')) {
            $i = $this->request->getJSON();
            $email_user = $i->email_user;

            $model = new M_login();
            $user = $model->validate_email($email_user);

            if ($user) {
                $update = $model->update_password($user['id_user'], ['password' => sha1('qwerty123#')]);
                if ($update) {
                    //konfigurasi email
                    $email = \Config\Services::email();
                    $email->setFrom('blevenpos@gmail.com', 'BLEVEN POS');
                    $email->setTo($email_user);

                    $email->setSubject('Lupa Password');
                    $email->setMessage('Password anda telah direset menjadi qwerty123#, Silahkan login kembali.');

                    if ($email->send()) {
                        $response = [
                            'status' => 200,
                            'message' => 'Email telah terkirim'
                        ];
                    } else {
                        $response = [
                            'status' => 500,
                            'message' => 'Email gagal terkirim'
                        ];
                    }
                } else {
                    $response = [
                        'status' => 500,
                        'message' => 'Password gagal direset'
                    ];
                }
            } else {
                $response = [
                    'status' => 401,
                    'message' => 'Email tidak ditemukan'
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
