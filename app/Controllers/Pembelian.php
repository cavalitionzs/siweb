<?php

namespace App\Controllers;

use \App\Models\KomikModel;
use \App\Models\SupplierModel;
use \App\Models\KomikSaleModel;
use \App\Models\KomikSaleDetailModel;

define('_TITLE', 'Data Pembelian');

class Pembelian extends BaseController
{
    private $komik, $cart, $supp, $sale, $saleDetail;
    public function __construct()
    {
        $this->komik = new KomikModel();
        $this->supp = new SupplierModel();
        $this->sale       = new KomikSaleModel();
        $this->saleDetail = new KomikSaleDetailModel();
        $this->cart = \Config\Services::cart();
    }
    public function index()
    {
        $this->cart->destroy();
        $komik = $this->komik->getBook();
        $supp = $this->supp->findAll();
        $data = [
            'title'     => _TITLE,
            'komik' => $komik,
            'supp' => $supp,
        ];
        return view('pembelian/list', $data);
    }

    public function showCart()
    {
        $output = '';
        $no = 1;

        foreach ($this->cart->contents() as $items) {
            $output .= '
            <tr>
            <td>' . $no++ . '</td>
            <td>' . $items['name'] . '</td>
            <td>' . $items['qty'] . '</td>
            <td>' . number_to_currency($items['price'], 'IDR', 'id_ID', 2)  . '</td>
            <td>' . number_to_currency(($items['subtotal']), 'IDR', 'id_ID', 2)  . '</td>
            <td>
            <button id="' . $items['rowid'] . '" qty="' . $items['qty'] . '"
            class="ubah_cart btn btn-warning btn-xs" title="Ubah Jumlah"><i class="fa
            fa-edit"></i></button>
            <button type="button" id="' . $items['rowid'] . '" class="hapus_cart btn
            btn-danger btn-xs"><i class="fa fa-trash" title="Hapus"></i></button>
            </td>
            </tr>
            ';
        }

        if (!$this->cart->contents()) {
            $output = '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        }
        return $output;
    }

    public function loadCart()
    {
        // load data cart
        echo $this->showCart();
    }

    public function addCart()
    {
        $this->cart->insert(array(
            'id'           => $this->request->getVar('id'),
            'qty'          => $this->request->getVar('qty'),
            'price'        => $this->request->getVar('price'),
            'name'         => $this->request->getVar('name'),
            'options'      => array(
                'discount' => $this->request->getVar('discount')
            )
        ));
        echo $this->showCart();
    }

    public function updateCart()
    {
        $this->cart->update(array(
            'rowid'     => $this->request->getVar('rowid'),
            'qty'       => $this->request->getVar('qty')
        ));
        echo $this->showCart();
    }

    public function deleteCart($rowid)
    {
        // Fungsi untuk menghapus item cart
        $this->cart->remove($rowid);
        echo $this->showCart();
    }

    public function getTotal()
    {
        $totalBayar = 0;
        foreach ($this->cart->contents() as $items) {
            $totalBayar += $items['subtotal'];
        }
        echo number_to_currency($totalBayar, 'IDR', 'id_ID', 2);
    }

    public function pembayaran()
    {
        if (!$this->cart->contents()) {
            // Ga Ada Transaksi
            $response = [
                'status'    => false,
                'msg'       => "Tidak Ada Transaksi!",
            ];
            echo json_encode($response);
        } else {
            // Ada Transaksi
            $totalBayar = 0;
            foreach ($this->cart->contents() as $items) {
                $totalBayar += $items['subtotal'];
            }

            $nominal = $this->request->getVar('nominal');
            $id = "B" . time();
            // Pengecekan apakah nominal yang dimasukkan cukup atau kurang
            if ($nominal < $totalBayar) {
                $response = [
                    'status'    => false,
                    'msg'       => "Nominal Pembayaran Kurang!",
                ];
                echo json_encode($response);
            } else {
                // Jika nominal memenuhi, akan menyimpan data di tabel sale dan sale_detail
                $this->sale->save([
                    'sale_id'    => $id,
                    'user_id'    => session()->user_id,
                    'supplier_id' => $this->request->getVar('id-supp')
                ]);

                foreach ($this->cart->contents() as $items) {
                    $this->saleDetail->save([
                        'sale_id'    => $id,
                        'komik_id'    => $items['id'],
                        'amount'     => $items['qty'],
                        'price'      => $items['price'],
                        'total_price' => $items['subtotal'],
                    ]);

                    // Mengurangi Jumlah stock di tabel buku
                    // Get buku berdasarkan ID Buku
                    $komik = $this->komik->where(['komik_id' => $items['id']])->first();
                    $this->komik->save([
                        'komik_id'  => $items['id'],
                        'stock'    => $komik['stock'] - $items['qty'],
                    ]);
                }

                $this->cart->destroy();
                $kembalian = $nominal - $totalBayar;

                $response = [
                    'status'    => true,
                    'msg'       => "Pembayaran Berhasil!",
                    'data'      => [
                        'kembalian' => number_to_currency(
                            $kembalian,
                            'IDR',
                            'id_ID',
                            2
                        )
                    ]
                ];
                echo json_encode($response);
            }
        }
    }
}
