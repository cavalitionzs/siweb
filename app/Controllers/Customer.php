<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

define('_TITLE', 'Data Customer');

class Customer extends BaseController
{
    public function index()
    {
        $crud = new GroceryCrud();
        $crud->setLanguage('Indonesian');
        $crud->columns(['name', 'no_customer', 'gender', 'address', 'email', 'phone']);
        $crud->unsetColumns(['created_at', 'updated_at']);
        $crud->displayAs(array(
            'name' => 'Nama',
            'gender' => 'L/P',
            'address' => 'Alamat',
            'phone' => 'Telp',
        ));
        $crud->where('deleted_at', null);
        $crud->unsetAddFields(['created_at', 'updated_at']);
        $crud->unsetEditFields(['created_at', 'updated_at']);
        $crud->setRule('name', 'Nama', 'required', [
            'required' => '{field} harus diisi!'
        ]);
        // $crud->unsetAdd(); // Nonaktif Tombol Tambah Data
        // $crud->unsetEdit(); // Nonaktif Tombol Ubah Data
        // $crud->unsetDelete(); // Nonaktif Tombol Hapus Data
        $crud->unsetExport(); // Nonaktif Tombol Export Data
        $crud->unsetPrint(); // Nonaktif Tombol Print Data
        $crud->setTable('customer');
        $output = $crud->render();

        $data = [
            'title' => _TITLE,
            'result' => $output
        ];
        // return view('example', (array)$output);
        return view('customer/index', $data);
    }
}
