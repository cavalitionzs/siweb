<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    // Nama Tabel //
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['firstname', 'lastname', 'role', 'user_name', 'user_email', 'user_password', 'user_created_at'];
}
