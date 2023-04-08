<?php

namespace App\Controllers;

use \App\Models\CategoryModel;
use App\Libraries\GroceryCrud;

define('_TITLE', 'Data Mahasiswa');

class Mahasiswa extends BaseController
{
    private $catModel;
    public function __construct()
    {
        $this->catModel = new CategoryModel();
    }

    public function index()
    {
        $crud = new GroceryCrud();
        $crud->setLanguage('Indonesian');
        $crud->columns(['nama', 'tempat_lahir', 'jenis_kelamin', 'hobi', 'kategori_favorit']);
        // $crud->unsetColumns(['created_at', 'updated_at']);
        $crud->displayAs(array(
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'hobi' => 'Hobi',
            'kategori_favorit' => 'Kategori Favorit'
        ));
        // $crud->where('deleted_at', null);
        // $crud->unsetAddFields(['created_at', 'updated_at']);
        // $crud->unsetEditFields(['created_at', 'updated_at']);
        $crud->setRule('nama', 'Nama', 'required', [
            'required' => '{field} harus diisi!'
        ]);
        $crud->setRelation('kategori_favorit', 'book_category', 'name_category');
        // $crud->unsetAdd(); // Nonaktif Tombol Tambah Data
        // $crud->unsetEdit(); // Nonaktif Tombol Ubah Data
        // $crud->unsetDelete(); // Nonaktif Tombol Hapus Data
        $crud->unsetExport(); // Nonaktif Tombol Export Data
        $crud->unsetPrint(); // Nonaktif Tombol Print Data
        $crud->setTable('mahasiswa_1038');
        $output = $crud->render();

        $data = [
            'title' => _TITLE,
            'result' => $output
        ];
        // return view('example', (array)$output);
        return view('mahasiswa/index', $data);
    }
}
