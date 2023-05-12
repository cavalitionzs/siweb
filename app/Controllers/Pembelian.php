<?php

namespace App\Controllers;

use \App\Models\KomikModel;
use \App\Models\SupplierModel;

define('_TITLE', 'Data Pembelian');

class Pembelian extends BaseController
{
    private $komik, $cart, $supp;
    public function __construct()
    {
        $this->komik = new KomikModel();
        $this->supp = new SupplierModel();
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

    public function getTotal()
    {
        $totalBayar = 0;
        foreach ($this->cart->contents() as $items) {
            $diskon = ($items['options']['discount'] / 100) * $items['subtotal'];
            $totalBayar += $items['subtotal'] - $diskon;
        }
        echo number_to_currency($totalBayar, 'IDR', 'id_ID', 2);
    }
}
