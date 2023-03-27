<?php

namespace App\Models;

use CodeIgniter\Model;

class M_login extends Model
{
    protected $table = 'users';

    public function validate_user($email_user, $password)
    {
        $user = $this->where(['email_user' => $email_user, 'password' => sha1($password)])
            ->first();

        if (!empty($user)) {
            return $user;
        }

        return false;
    }

    public function validate_email($email_user)
    {
        $user = $this->where(['email_user' => $email_user])
            ->first();

        if (!empty($user)) {
            return $user;
        }

        return false;
    }

    public function update_password($id, $data)
    {
        $query = $this->db->table($this->table)->update($data, ['id_user' => $id]);
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
