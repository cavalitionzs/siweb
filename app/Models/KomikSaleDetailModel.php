<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikSaleDetailModel extends Model
{
    // Nama Tabel
    protected $table         = 'komik_sale_detail';
    protected $allowedFields = ['sale_id', 'komik_id', 'amount', 'price', 'discount', 'total_price'];
}
