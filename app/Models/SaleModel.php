<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    // Nama Tabel
    protected $table         = 'sale';
    protected $useTimestamps = true;
    protected $allowedFields = ['sale_id', 'user_id', 'customer_id'];
}
