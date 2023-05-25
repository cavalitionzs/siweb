<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikBuyDetailModel extends Model
{
    // Nama Tabel
    protected $table         = 'komik_buy_detail';
    protected $allowedFields = ['buy_id', 'komik_id', 'amount', 'price', 'discount', 'total_price'];

    public function getInvoice($buy_id)
    {
        return $this->select('komik_buy_detail.buy_id, komik_buy_detail.amount amount, komik_buy_detail.price price, 
        komik_buy_detail.total_price total, k.title title, kb.created_at tgl_transaksi')
            ->join('komik k', 'komik_id')
            ->join('komik_buy kb', 'buy_id')
            ->where('buy_id', $buy_id)
            ->findAll();
    }
}
