<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikSaleModel extends Model
{
    // Nama Tabel
    protected $table         = 'komik_sale';
    protected $useTimestamps = true;
    protected $allowedFields = ['sale_id', 'user_id', 'supplier_id'];
}
