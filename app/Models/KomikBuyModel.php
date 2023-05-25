<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikBuyModel extends Model
{
    // Nama Tabel
    protected $table         = 'komik_buy';
    protected $useTimestamps = true;
    protected $allowedFields = ['buy_id', 'user_id', 'supplier_id'];

    public function getReport($tgl_awal, $tgl_akhir)
    {
        return $this->db->table('komik_buy_detail as kbd')
            ->select('kb.buy_id, kb.created_at tgl_transaksi, us.id user_id, us.firstname, us.lastname, , us.user_name, s.supplier_id, s.name name_supp, s.no_supplier, SUM(kbd.total_price) total')
            ->join('komik_buy kb', 'buy_id')
            ->join('pengguna us', 'us.id = kb.user_id')
            ->join('supplier s', 'supplier_id', 'left')
            ->where('date(kb.created_at) >=', $tgl_awal)
            ->where('date(kb.created_at) <=', $tgl_akhir)
            ->groupBy('kb.buy_id')
            ->get()->getResultArray();
    }
}
