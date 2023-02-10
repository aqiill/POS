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
}
