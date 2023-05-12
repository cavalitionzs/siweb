<?php

namespace App\Controllers;

use \App\Models\BookModel;
use \App\Models\CustomerModel;
use \App\Models\SaleModel;
use \App\Models\SaleDetailModel;

define('_TITLE', 'Data Penjualan');

class Penjualan extends BaseController
{
    private $book, $cart, $cust, $sale, $saleDetail;
    public function __construct()
    {
        $this->book       = new BookModel();
        $this->cust       = new CustomerModel();
        $this->sale       = new SaleModel();
        $this->saleDetail = new SaleDetailModel();
        $this->cart       = \Config\Services::cart();
    }
    public function index()
    {
        $this->cart->destroy();
        $book = $this->book->getBook();
        $cust = $this->cust->findAll();
        $data = [
            'title'     => _TITLE,
            'book' => $book,
            'cust' => $cust,
        ];
        return view('penjualan/list', $data);
    }

    public function showCart()
    {
        $output = '';
        $no = 1;

        foreach ($this->cart->contents() as $items) {
            $diskon = ($items['options']['discount'] / 100) * $items['subtotal'];
            $output .= '
            <tr>
            <td>' . $no++ . '</td>
            <td>' . $items['name'] . '</td>
            <td>' . $items['qty'] . '</td>
            <td>' . number_to_currency($items['price'], 'IDR', 'id_ID', 2)  . '</td>
            <td>' . number_to_currency($diskon, 'IDR', 'id_ID', 2) . '</td>
            <td>' . number_to_currency(($items['subtotal'] - $diskon), 'IDR', 'id_ID', 2)  . '</td>
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
            $diskon = ($items['options']['discount'] / 100) * $items['subtotal'];
            $totalBayar += $items['subtotal'] - $diskon;
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
                $diskon = ($items['options']['discount'] / 100) * $items['subtotal'];
                $totalBayar += $items['subtotal'] - $diskon;
            }

            $nominal = $this->request->getVar('nominal');
            $id = "J" . time();
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
                    'customer_id' => $this->request->getVar('id-cust')
                ]);

                foreach ($this->cart->contents() as $items) {
                    $this->saleDetail->save([
                        'sale_id'    => $id,
                        'book_id'    => $items['id'],
                        'amount'     => $items['qty'],
                        'price'      => $items['price'],
                        'discount'   => $diskon,
                        'total_price' => $items['subtotal'] - $diskon,
                    ]);

                    // Mengurangi Jumlah stock di tabel buku
                    // Get buku berdasarkan ID Buku
                    $book = $this->book->where(['book_id' => $items['id']])->first();
                    $this->book->save([
                        'book_id'  => $items['id'],
                        'stock'    => $book['stock'] - $items['qty'],
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
